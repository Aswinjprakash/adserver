<?php

namespace App\Http\Controllers\Admin;

use App\Models\IpLog;
use App\Models\AdType;
use App\Models\IpChart;
use App\Models\Keyword;
use App\Models\CreateAd;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Http\Controllers\Controller;

class AdvertiseController extends Controller
{


    public function allAdvertise()
    {
        $pageTitle = 'Advertises List';
        $advertises = CreateAd::with('advertiser')->latest()->paginate(getPaginate());
        return view('admin.advertises.all_advertises',compact('advertises','pageTitle'));
    }

    public function editAdvertise($id){
        $pageTitle = 'Edit Advertise';
        $advertise = CreateAd::findOrFail($id);
        return view('admin.advertises.edit',compact('pageTitle','advertise'));
    }

    public function updateAdvertise(Request $request, $id)
    {

        $request->validate([
            'url' => 'required|url',
            'country' => $request->has('global') ? 'nullable' : 'required',
        ]);

        $allCountries = json_decode(file_get_contents(resource_path('views/includes/country.json')));

        $ad = CreateAd::findOrFail($id);
        $ad->redirect_url = $request->url;

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


    public function updateAdStatus(Request $request){
        $advertise = CreateAd::findOrFail($request->id);
        $advertise->status = $request->status;
        $advertise->save();

        $notify[]=['success','Successfully status change'];
        return back()->withNotify($notify);
    }


    public function getAdType(){
        $pageTitle = 'Ad Types List';
        $adTypes  = AdType::latest()->paginate(getPaginate());
        return view('admin.advertises.adTypes',compact('pageTitle','adTypes'));
    }

    public function AdTypeStore(Request $request){
        $request->validate([
            'ad_name'=> 'required',
            'type' => 'required',
            'width'=>'required|integer|gt:0',
            'height' =>'required|integer|gt:0',
            'slug'=>'required|unique:ad_types',
        ]);

        if(AdType::where('slug',$request->width.'x'.$request->height)->first()){
            $notify[]=['error','Slug has already been taken'];
           return back()->withNotify($notify);
       }

        $adType = new AdType();
        $adType->ad_name = $request->ad_name;
        $adType->type = $request->type;
        $adType->width = $request->width;
        $adType->height = $request->height;
        $adType->slug = $request->width.'x'.$request->height;
        $adType->status = 1;
        $adType->save();

        $notify[]=['success','AdType added successfully'];
        return back()->withNotify($notify);

    }

    public function AdTypeUpdate(Request $request){

        $request->validate([
            'ad_name'=> 'required',
            'type' => 'required',
            'width'=>'required|integer|gt:0',
            'height' =>'required|integer|gt:0',
            'slug'=>'required',
        ]);

        $adType = AdType::findOrFail($request->id);
        $adType->ad_name = $request->ad_name;
        $adType->type = $request->type;
        $adType->width = $request->width;
        $adType->height = $request->height;
        $adType->slug = $request->width.'x'.$request->height;
        isset($request->status) ? $adType->status = 1 : $adType->status = 0;
        $adType->save();

        $notify[]=['success','AdType updated successfully'];
        return back()->withNotify($notify);

    }

    // keyword
    public function getKeyWords(){
        $pageTitle = 'Keyword Lists';
        $keywords = Keyword::latest()->paginate(getPaginate());
        return view('admin.keyword.index',compact('pageTitle','keywords'));
    }

    public function keyWordsStore(Request $request)
    {
        $request->validate([
            'keywords' => 'required',
        ]);

        $text = str_replace('"','',json_encode($request->keywords));
        $keywords = explode("\\r\\n",$text);
        foreach($keywords as $keyword){
            Keyword::create([
                'keywords'=>$keyword
            ]);
        }
        $notify[]=['success','Keywords added successfully'];
        return back()->withNotify($notify);
    }

    public function keyWordsUpdate(Request $request){
        $request->validate([
            'keyword' => 'required',
        ]);

        $keyword = Keyword::findOrFail($request->id);
        $keyword->keywords = $request->keyword;
        $keyword->save();
        $notify[]=['success','Keyword updated successfully'];
        return back()->withNotify($notify);
    }

    // ip logs
    public function ipLog(Request $request)
    {
        $pageTitle = 'Advertise Ip Logs';
        $logs = IpLog::latest()->whereHas('ad')->whereHas('ip',function($ip){
            $ip->where('blocked',0);
        })->with(['ad','ip'])->paginate(getPaginate());

        return view('admin.advertises.ip_logs',compact('pageTitle','logs'));
    }

    public function blockiplog(Request $request)
    {
        $pageTitle = 'Advertise Block Ip Logs';
        $logs = IpLog::latest()->whereHas('ad')->whereHas('ip',function($ip){
            $ip->where('blocked',1);
        })->with(['ad','ip'])->paginate(getPaginate());

        return view('admin.advertises.block_ip_logs',compact('pageTitle','logs'));
    }

    public function blockIp(Request $request)
    {
        $block = IpChart::findOrFail($request->id);
        $block->blocked = 1;
        $block->save();
        $notify[]=['success','Ip has been blocked successfully'];
        return back()->withNotify($notify);
    }

    public function unblockIp(Request $request)
    {
        $block = IpChart::findOrFail($request->id);
        $block->blocked = 0;
        $block->save();
        $notify[]=['success','Ip has been unblocked successfully'];
        return back()->withNotify($notify);
    }






}
