<?php

namespace App\Http\Controllers;

use App\Models\IpLog;
use App\Models\AdType;
use App\Models\IpChart;
use App\Models\Analytic;
use App\Models\CreateAd;
use App\Models\Purchase;
use App\Models\Publisher;
use App\Models\Advertiser;
use App\Models\EarningLog;
use App\Models\PublisherAd;
use Illuminate\Support\Carbon;
use App\Models\DomainVerifcation;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;

class VisitorController extends Controller
{

    protected function defaultAd($slug, $width, $height, $title)
    {
        $logo = route('placeholder.image', $slug);
        return "<a href='" . url('/') . "' target='_blank'><img src='" . $logo . "' width='" . $width . "' height='" . $height . "'/></a><strong style='background-color:#e6e6e6;position:absolute;right:0;top:0;font-size: 10px;color: #666666; padding:4px; margin-right:15px;'>Ads by " . $title . "</strong><span onclick='hideAdverTiseMent(this)' style='position:absolute;right:0;top:0;width:15px;height:20px;background-color:#f00;font-size: 15px;color: #fff;border-radius: 1px;cursor: pointer;'>x</span>";
    }

    public function randomAd($redirectUrl, $adImage, $width, $height, $sitename)
    {
        return "<a href='" . $redirectUrl . "' target='_blank'><img src='" . $adImage . "' width='" . $width . "' height='" . $height . "'/></a><strong style='background-color:#e6e6e6;position:absolute;right:0;top:0;font-size: 10px;color: #666666; padding:4px; margin-right:15px;'>Ads by " . $sitename . "</strong><span onclick='hideAdverTiseMent(this)' style='position:absolute;right:0;top:0;width:15px;height:20px;background-color:#f00;font-size: 15px;color: #fff;border-radius: 1px;cursor: pointer;'>x</span>";
    }

    public function getIp()
    {
        if (Request::server('HTTP_CLIENT_IP')) {
            return Request::server('HTTP_CLIENT_IP');
        } elseif (Request::server('HTTP_X_FORWARDED_FOR')) {
            return Request::server('HTTP_X_FORWARDED_FOR');
        } else {
            return Request::server('REMOTE_ADDR') ? Request::server('REMOTE_ADDR') : '';
        }
    }

    public function getAdvertise($pubId, $slug, $currentUrl)
    {
        header("Access-Control-Allow-Origin: *");
        $publisherId = Crypt::decryptString($pubId);
        $adType = AdType::whereSlug($slug)->where('status', 1)->first();
        $setting = gs();

        $existingIp = IpChart::firstOrNew(['ip' => $this->getIp()]);
        if ($existingIp->blocked == 1) {
            return $this->defaultAd($slug, $adType->width, $adType->height, $setting->site_name);
        }
        $existingIp->save();

        $domain = DomainVerifcation::where('name', $currentUrl)
            ->where('publisher_id', $publisherId)
            ->where('status',1)->first();

        if (!$domain) {
            info("Domain not found or unverified");
            return $this->defaultAd($slug, $adType->width, $adType->height, $setting->site_name);
        }


        // $query = getIpInfo();
        $query = json_decode(file_get_contents('http://api.ipstack.com/' . $this->getIp() . '?access_key=' . $setting->location_api));

        if (@$query->error) {
            info("IP tracking  error", [
                'error' => @$query->error
            ]);
            return $this->defaultAd($slug, $adType->width, $adType->height, $setting->sitename);
        }

        if ($adType) {

            $queryAd = CreateAd::where('ad_type_id',$adType->id)->where('status',1);


            if ($setting->check_country && $query->country_name) {
                $queryAd->whereJsonContains('country', $query->country_name);
            }

            if ($setting->check_domain_keyword && $domain) {
                $domainKeywords = json_decode($domain->keywords);
                if ($domainKeywords) {
                    $queryAd->where(function ($q) use ($domainKeywords) {
                        foreach ($domainKeywords as $keyword) {
                            $q->orWhere('keywords', 'LIKE', "%$keyword%");
                        }
                    });
                }
            }

            $ads = $queryAd->inRandomOrder()->first();

            if(empty($ads)){
                return $this->defaultAd($slug, $adType->width, $adType->height, $setting->sitename);
            }

            $existIpLog = $existingIp->iplogs
                ->where('ad_id', $ads->id)
                ->where('time', '>=', Carbon::now()->subMinutes(1))
                ->first();

            if ($ads) {
                $publisher = Publisher::findOrFail($publisherId);
                $publisherAd = PublisherAd::firstOrNew([
                    'create_ad_id' => $ads->id,
                    'publisher_id' => $publisher->id,
                    'date' => Carbon::now()->toDateString()
                ]);
                $publisherAd->advertiser_id = $ads->advertiser_id;
                $publisherAd->imp_count += 1;
                $publisherAd->save();

                if ($ads->ad_type == 'impression') {

                    $advertiser = Advertiser::findOrFail($ads->advertiser_id);

                    if (!$existIpLog) {
                        $ipLog = new IpLog();
                        $ipLog->ip_id = $existingIp->id;
                        $ipLog->country = @$query->country_name;
                        $ipLog->ad_id = $ads->id;
                        $ipLog->ad_type = $ads->ad_type;
                        $ipLog->time = Carbon::now()->toTimeString();
                        $ipLog->save();

                        $ipcart = IpLog::with('ip')->where('created_at', '>=', Carbon::now()->subHours(24))->get();
                        $uniqueIps = $ipcart->pluck('ip.ip')->count();
                        if ($uniqueIps>3) {

                        }else{
                            if (@$advertiser->impression > 0) {
                                $advertiser->impression -= 1;
                                $advertiser->update();
                            } else {
                                $ads->status = 0;
                                $ads->update();
                                Purchase::where('advertiser_id', $ads->advertiser_id)
                                    ->where('type','impression')->delete();
                            }

                            if ($publisher) {
                                $publisher->balance += $setting->cpm;
                                $publisher->update();

                                $earningLog = EarningLog::firstOrNew([
                                    'publisher_id' => $publisher->id,
                                    'ad_id' => $ads->id,
                                ]);

                                $earningLog->amount += $setting->cpm;;
                                $earningLog->ad_type = $ads->ad_type;
                                $earningLog->save();
                            }
                        }

                    }
                }

                $redirectUrl = route('adClicked', [
                    encrypt($publisherId),
                    $ads->track_id,
                    $existingIp
                ]);

                $adImage = asset('assets/images/frontend/adImage') . '/' . $ads->image;
                $ads->impression += 1;
                $ads->update();

                $analytic = Analytic::firstOrNew([
                    'country' => @$query->country_name,
                    'advertiser_id' => $ads->advertiser_id,
                    'ad_id' => $ads->id
                ]);

                $analytic->ad_title = $ads->title;
                $analytic->imp_count += 1;
                $analytic->save();
            } else {
                info("Ad not found. ad type: " . $adType->slug);
                return $this->defaultAd($slug, $adType->width, $adType->height, $setting->site_name);
            }
        } else {
            info("Ad type not found. ad type: request ad type slug: " . $slug);
            return $this->defaultAd($slug, $adType->width, $adType->height, $setting->site_name);
        }

        return $this->randomAd($redirectUrl, $adImage, $adType->width, $adType->height, $setting->site_name);
    }

    public function adClicked($publisherId, $trackId)
    {
        $ad = CreateAd::where('track_id', $trackId)->first();
        $setting = gs();

        // $query = getIpInfo();
        $query = json_decode(file_get_contents('http://api.ipstack.com/' . $this->getIp() . '?access_key=' . $setting->location_api));

        $existingIp = IpChart::where('ip', $this->getIp())->first();
        $publisher = Publisher::findOrFail(decrypt($publisherId));
        $advertiser = Advertiser::findOrFail($ad->advertiser_id);

        $existIpLog = $existingIp->iplogs
            ->where('ad_id', $ad->id)
            ->where('time', '>=', Carbon::now()->subMinutes(1))
            ->first();

        if ($ad) {
            $publisherAd = PublisherAd::firstOrNew([
                'create_ad_id' => $ad->id,
                'publisher_id' => $publisher->id,
                'date' => Carbon::now()->toDateString()
            ]);

            $publisherAd->advertiser_id = $ad->advertiser_id;
            $publisherAd->click_count += 1;
            $publisherAd->save();

            if ($ad->ad_type == 'click') {
                // $ifPurchaseAdvertiser = getSubscriptionVisitor($advertiser->id, 'click');
                    $ifPurchaseAdvertiser = Advertiser::findOrFail($advertiser->id);
                if (!$existIpLog) {
                    $ipLog = new IpLog();
                    $ipLog->ip_id = $existingIp->id;
                    $ipLog->country = $query->country_name;
                    $ipLog->ad_id = $ad->id;
                    $ipLog->ad_type = $ad->ad_type;
                    $ipLog->time = Carbon::now()->toTimeString();
                    $ipLog->save();


                    $ipcart = IpLog::with('ip')->where('created_at', '>=', Carbon::now()->subHours(24))->get();
                    $uniqueIps = $ipcart->pluck('ip.ip')->count();

                    if ($uniqueIps>3) {

                    }else{

                        if (@$ifPurchaseAdvertiser->click > 0) {
                            $ifPurchaseAdvertiser->click -= 1;
                            $ifPurchaseAdvertiser->update();
                        } else {
                            $ad->status = 0;
                            $ad->update();
                            Purchase::where('advertiser_id', $advertiser->id)
                                ->where('type', 'click')->delete();
                        }

                        if ($publisher) {
                            $publisher->balance += $setting->cpc;
                            $publisher->update();

                            $earningLog = EarningLog::firstOrNew([
                                'publisher_id' => $publisher->id,
                                'ad_id' => $ad->id,
                            ]);

                            $earningLog->amount +=  $setting->cpc;
                            $earningLog->ad_type = $ad->ad_type;
                            $earningLog->save();

                        }
                    }
                }
            }

            $ad->clicked += 1;
            $ad->update();

            $analytic = Analytic::firstOrNew([
                'country' => @$query->country_name,
                'advertiser_id' => $ad->advertiser_id,
                'ad_id' => $ad->id
            ]);

            $analytic->ad_title = $ad->ad_title;
            $analytic->click_count += 1;
            $analytic->save();

            return redirect($ad->redirect_url);
        } else {
            return redirect(url('/'));
        }
    }


    public function setErrorLog($message, $errors = [])
    {
        info($message, $errors);
    }



}
