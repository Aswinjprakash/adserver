<?php

namespace App\Http\Controllers\Publisher;

use App\Models\AdType;
use App\Models\PublisherAd;
use App\Http\Controllers\Controller;

class AdvertiseController extends Controller
{
    public function advertises()
    {
        $ads = AdType::where('status',1)->latest()->paginate(getPaginate());
        $pageTitle = 'Advertise Types';
        return view($this->activeTemplate.'publisher.advertises.advertises',compact('ads','pageTitle'));
    }

    public function publishedAd(){
        $pageTitle ='Published Ads';
        $publisherAds = PublisherAd::where('publisher_id',auth()->guard('publisher')->user()->id)
                                    ->with('advertise')->paginate(getPaginate());
        return view($this->activeTemplate.'publisher.advertises.published_ad',compact('pageTitle','publisherAds'));
    }


}
