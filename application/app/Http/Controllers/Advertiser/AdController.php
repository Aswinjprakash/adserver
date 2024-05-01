<?php

namespace App\Http\Controllers\Advertiser;

use App\Models\AdType;
use App\Models\Keyword;
use App\Models\Analytic;
use App\Models\CreateAd;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;


class AdController extends Controller
{
    public function index(){
        $pageTitle = 'Advertises List';
        $advertises = CreateAd::with('advertiser')->whereAdvertiserId(Auth()->guard('advertiser')->id())->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'advertiser.ads.index',compact('pageTitle','advertises'));
    }

    public function getAdTypes(){
        $pageTitle = 'Ad Type Lists';
        $adTypes = AdType::active()->latest()->paginate(getPaginate(8));
        $isPurchase = isSubscribe(auth()->guard('advertiser')->user()->id);
        return view($this->activeTemplate.'advertiser.ads.adsType',compact('pageTitle','adTypes','isPurchase'));
    }

    public function create($id){
        $pageTitle = 'Ad create';
        $adType = AdType::findOrFail($id);
        $keywords =  Keyword::latest()->get();
        $info = json_decode(json_encode(getIpInfo()), true);
        $countries = json_decode(file_get_contents(resource_path('views/includes/country.json')));
        return view($this->activeTemplate.'advertiser.ads.create',compact('pageTitle','adType','keywords','countries'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'type' => 'required|in:click,impression',
            'url' => 'required|url',
            'country' => 'sometimes|required|array',
            'country.*' => 'sometimes|required',
            'image' => ['required', 'max:1024', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png', 'gif'])]
        ]);

        $allCountries = json_decode(file_get_contents(resource_path('views/includes/country.json')));

        $ad = new CreateAd ();
        $ad->advertiser_id = $request->advertiser;
        $ad->title = $request->title;
        $ad->ad_name = $request->ad_name;
        $ad->redirect_url = $request->url;

        $subscribe = isSubscribe(auth()->guard('advertiser')->user()->id);
        $hasActiveSubscription = false;
        foreach ($subscribe as $subscription) {
            if ($request->type == 'click' && $subscription->click_point > 0) {
                $hasActiveSubscription = true;
                break;
            } elseif ($request->type == 'impression' && $subscription->impression_point > 0) {
                $hasActiveSubscription = true;
                break;
            }
        }

        if (!$hasActiveSubscription) {
            $notify[] = ['error', 'Please purchase ' . ucfirst($request->type) . ' plan first'];
            return back()->withNotify($notify);
        }

        $ad->ad_type = $request->type;
        $ad->ad_type_id = $request->ad_type_id;
        $ad->keywords = json_encode($request->keywords);

        if ($request->global == 'on') {
            $ad->global = 1;

            $c_name = [];
            foreach ($allCountries as $cr) {
              $c_name [] = $cr->country;
            }
            $ad->country = json_encode($c_name);
        } else {
            $ad->country = null;
        }

        isset($request->country) ? $ad->country = json_encode($request->country): null;
        $ad->track_id = Str::random(12);
        $ad->status = 2;

        if ($request->file('image')) {
            $width = Image::make($request->image)->width();
            $height = Image::make($request->image)->height();

            $ad->resolution = $width . 'x' . $height;
            $addType = AdType::findOrFail($request->ad_type_id);

            if ($addType->width != $width || $addType->height != $height) {
                $notify[] = ['error', 'Image resolution must be ' . $addType->width . 'x' . $addType->height . 'px'];
                return back()->withNotify($notify);
            } else {
                $ad->image = fileUploader($request->image, getFilePath('adImage'));
            }

        }

        $ad->save();

        $notify[] = ['success', 'Ad has been created successfully'];
        return back()->withNotify($notify);

    }

    public function edit($id){
        $pageTitle = 'Upate Ad';
        $ad = CreateAd::findOrFail($id);

        if ($ad->advertiser_id != auth()->guard('advertiser')->id()) {
            $notify[] = ['error', 'Sorry Ad details not found'];
            return back()->withNotify($notify);
        }
        return view($this->activeTemplate.'advertiser.ads.edit',compact('pageTitle','ad'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'url' => 'required|url',
            'country' => $request->has('global') ? 'nullable' : 'required',
            'title' => 'required'
        ]);

        $allCountries = json_decode(file_get_contents(resource_path('views/includes/country.json')));

        $ad = CreateAd::findOrFail($id);
        $ad->redirect_url = $request->url;
        $ad->title = $request->title;

        if (isset($request->global)) {
            $ad->global = 1;
            $c_name = [];

            foreach ($allCountries as $cr) {
                $c_name [] = $cr->country;
            }
            $ad->country = json_encode($c_name);

        } else {
            $ad->country = json_encode($request->country);
            $ad->global = 0;
        }

        $ad->keywords = json_encode($request->keywords);
        $ad->save();
        $notify[] = ['success', 'Ad has been updated successfully'];
        return back()->withNotify($notify);

    }

    public function updateStatus(Request $request){

        $ad = CreateAd::findOrFail($request->id);
        $ad->status = $request->status;

        $subscribe = isSubscribe(auth()->guard('advertiser')->user()->id);
        foreach ($subscribe as $subscription) {
            if ($request->type == 'click' && $subscription->click_point > 0) {
                $ad->status = 1;
                break;
            } elseif ($request->type == 'impression' && $subscription->impression_point > 0) {
                $ad->status = 1;
                break;
            }else{
                $ad->status = $request->status;
            }
        }
        
        $ad->save();
        $notify[] = ['success', 'Status change successfully'];
        return back()->withNotify($notify);

    }

    public function delete(Request $request){
        $ad = CreateAd::findOrFail($request->id);
        $imagePath = getFilePath('adImage') . '/' . $ad->image;
        fileManager()->removeFile($imagePath);
        $ad->delete();

        $notify[] = ['success', 'Ad has been deleted successfully'];
        return back()->withNotify($notify);

    }

    public function adReport()
    {
        $adReports = Analytic::with('ad')->whereAdvertiserId(auth()->guard('advertiser')->user()->id)->latest()->paginate(getPaginate());
        $pageTitle = 'Advertise Reports';
        return view($this->activeTemplate.'advertiser.ads.report', compact('adReports', 'pageTitle'));
    }

    public function adReportSearch(Request $request)
    {
        $pageTitle = 'Ad Report Search Results';
        $query = $request->search;

        $advertiserId = auth()->guard('advertiser')->user()->id;

        $adReports = Analytic::where(function ($queryBuilder) use ($advertiserId, $query) {
            $queryBuilder->where('advertiser_id', $advertiserId)
                         ->where(function ($innerQueryBuilder) use ($query) {
                             $innerQueryBuilder->where('country', 'like', "%$query%")
                                               ->orWhere('ad_title', 'like', "%$query%");
                         });
        })->paginate(getPaginate());

        return view($this->activeTemplate . 'advertiser.ads.report', compact('adReports', 'pageTitle'));
    }



}
