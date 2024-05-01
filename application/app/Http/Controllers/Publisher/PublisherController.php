<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Keyword;
use App\Models\EarningLog;
use App\Models\Withdrawal;
use App\Models\PublisherAd;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Lib\GoogleAuthenticator;
use App\Models\DomainVerifcation;
use App\Http\Controllers\Controller;


class PublisherController extends Controller
{
    public function dashboard(){
        $pageTitle='Dashboard';
        $user =  auth()->guard('publisher')->user();
        $widget['total_imp'] = PublisherAd::where('publisher_id',$user->id)->sum('imp_count');
        $widget['total_click'] = PublisherAd::where('publisher_id',$user->id)->sum('click_count');
        $widget['balance'] = $user->balance;

        $withdrawalsReport = Withdrawal::where('user_id',$user->id)->selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
       ->whereYear('created_at', date('Y'))
       ->whereStatus(1)
       ->groupBy('month_name', 'month_num')
       ->orderBy('month_num')
       ->get();
        $withdrawalsChart['labels'] = $withdrawalsReport->pluck('month_name');
        $withdrawalsChart['values'] = $withdrawalsReport->pluck('amount');

        $earning = EarningLog::where('publisher_id',$user->id)->selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name', 'month_num')
        ->orderBy('month_num')
        ->get();
         $earningsChart['labels'] = $earning->pluck('month_name');
         $earningsChart['values'] = $earning->pluck('amount');

        return view($this->activeTemplate.'publisher.dashboard',compact('pageTitle','withdrawalsChart','earningsChart','widget'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->guard('publisher')->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate.'publisher.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->guard('publisher')->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->guard('publisher')->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('publisher_id',auth()->guard('publisher')->id());

        if ($request->search) {
            $transactions = $transactions->where('trx',$request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type',$request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark',$request->remark);
        }

        $transactions = $transactions->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'publisher.transactions', compact('pageTitle','transactions','remarks'));
    }

    public function userData()
    {
        $user = auth()->guard('publisher')->user();
        if ($user->reg_step == 1) {
            return to_route('publisher.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate.'publisher.user_data', compact('pageTitle','user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->guard('publisher')->user();
        if ($user->reg_step == 1) {
            return to_route('publisher.home');
        }
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country'=>@$user->address->country,
            'address'=>$request->address,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'city'=>$request->city,
        ];
        $user->reg_step = 1;
        $user->save();

        $notify[] = ['success','Registration process completed successfully'];
        return to_route('publisher.home')->withNotify($notify);

    }

    // domain
    public function getDomain(){
        $pageTitle = 'Domain Lists';
        $domains = DomainVerifcation::where('publisher_id',auth()->guard('publisher')->user()->id)->latest()->paginate(getPaginate());
        $keywords = Keyword::latest()->get();
        return view($this->activeTemplate.'publisher.domains.index',compact('pageTitle','domains','keywords'));
    }

    public function domainStore(Request $request){

        $request->validate(
            [
                'name' => ['required', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
                'keywords' => 'required',
                'keywords.*' => 'required'
            ],
            [
                'keywords.*.required' => 'The Keywords field is required',
                'name.url' => 'Please Enter a valid Url'
            ]
        );

        $domian = new DomainVerifcation();
        $domian->tracker = getTrx(8) . rand(0, 100);
        $domian->name =urlToDomain($request->name);
        $domian->publisher_id = auth()->guard('publisher')->user()->id;
        $domian->verify_code = getTrx(32);
        $domian->keywords = json_encode($request->keywords);
        $domian->status = 0;
        $domian->save();
        $notify[] = ['success', 'Domain submitted'];
        return back()->withNotify($notify);

    }

    public function domainVerifyAct($tracker)
    {

        $general = gs();
        $pageTitle = "Verify the Domain";
        $domain = DomainVerifcation::whereTracker($tracker)->first();
        if (!$domain) {
            $notify[] = ['error', 'Sorry domain couldn\'t found'];
            return back()->withNotify($notify);
        }
        $fileName = strtolower(str_replace(' ', '_', $general->site_name)) . '.txt';
        $fileURL = 'http://' . $domain->name . '/' . strtolower(str_replace(' ', '_', $general->site_name)) . '.txt';
        return view($this->activeTemplate . 'publisher.domains.verify_page', compact('pageTitle', 'domain', 'fileURL', 'fileName'));
    }

    public function domainCheck($tracker)
    {
        $general = gs();
        $domain = DomainVerifcation::whereTracker($tracker)->first();

        $fileURL = 'http://' . $domain->name . '/' . strtolower(str_replace(' ', '_', $general->site_name)) . '.txt';

        $headers = @get_headers($fileURL);
        if (empty($headers) || strpos($headers[0], '404') !== false) {
            $notify[] = ['error', 'The verification file is not accessible. Please make sure it\'s uploaded'];
            return back()->withNotify($notify);
        }

        if (auth()->guard('publisher')->user()->id == $domain->publisher_id) {
            $verification = @file_get_contents($fileURL);

            if ($verification == false) {
                $notify[] = ['error', 'We couldn\'t access the verification file. Please try again'];
                return back()->withNotify($notify);
            }

            if ($domain->verify_code == $verification) {
                $general->domain_approval == 1 ? $domain->status = 2 : $domain->status = 1;
                $domain->save();
                $general->domain_approval == 1 ? $notify[] = ['info', 'Your domain has been submitted for approval'] : $notify[] = ['success', 'Your domain has been verified'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'We couldn\'t verify your domain. Please try again'];
                return back()->withNotify($notify);
            }
        }

        $notify[] = ['error', 'Access Denied'];
        return back()->withNotify($notify);
    }


    public function editDomainKeyword($id) {
        $pageTitle = 'Update Keywords';
        $domain =  DomainVerifcation::findOrFail($id);
        $keywords = Keyword::latest()->get();
        $selectedKeywords = json_decode($domain->keywords);
        return view($this->activeTemplate.'publisher.domains.edit', compact('pageTitle', 'domain', 'keywords', 'selectedKeywords'));
    }

    public function updateDomainKeyword(Request $request, $tracker)
    {
        $request->validate([
            'keywords' => 'required'
        ]);
        $domain = DomainVerifcation::whereTracker($tracker)->first();
        $domain->keywords = json_encode($request->keywords);
        $domain->update();
        $notify[] = ['success', 'Domain has been been Updated successfully'];
        return back()->withNotify($notify);
    }

    public function domainRemove($tracker)
    {
        $domain = DomainVerifcation::whereTracker($tracker)->first();
        $domain->delete();
        $notify[] = ['success', 'domain has been deleted successfully'];
        return back()->withNotify($notify);
    }

    public function domainDelete(Request $request)
    {

        $domain = DomainVerifcation::findOrFail($request->id);
        $domain->delete();
        $notify[] = ['success', 'domain has been deleted successfully'];
        return back()->withNotify($notify);
    }

    public function publishedPerdayAd(){
        $pageTitle = 'Per Day Ad Log';
        $perdayAds = PublisherAd::where('publisher_id',auth()->guard('publisher')->user()->id)
                                ->with('advertise')->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'publisher.advertises.ad_report',compact('pageTitle','perdayAds'));
    }

    public function earningLog(){
        $pageTitle = 'Per Day Earning Log';
        $perdayEarnings = EarningLog::where('publisher_id',auth()->guard('publisher')->user()->id)
                                ->with('ad')->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'publisher.advertises.earning',compact('pageTitle','perdayEarnings'));
    }


    public function adReportSearch(Request $request)
    {
        $pageTitle = "Search Result";
        $notify = [];

        if ($request->date) {
            $dateRange = explode(' - ', $request->date);

            if (count($dateRange) !== 2) {
                $notify[] = ['error', 'Invalid Date Range Format'];
            } else {
                $formattedDates = array_map(function ($date) {
                    return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
                }, $dateRange);

                if (!strtotime($formattedDates[0]) || !strtotime($formattedDates[1])) {
                    $notify[] = ['error', 'Invalid Date Format'];
                }

                if (empty($notify)) {
                    $perdayAds = PublisherAd::with('advertise')
                        ->wherePublisherId(auth()->guard('publisher')->id())
                        ->whereBetween('created_at', $formattedDates)
                        ->paginate(getPaginate());
                }
            }
        } else {
            $notify[] = ['error', 'Invalid Date'];
        }

        if (!empty($notify)) {
            return back()->withNotify($notify);
        }

        return view($this->activeTemplate . 'publisher.advertises.ad_report', compact('pageTitle', 'perdayAds'));
    }

    public function adReportEarning(Request $request)
    {
        $pageTitle = "Search Result";
        $notify = [];

        if ($request->date) {
            $dateRange = explode(' - ', $request->date);

            if (count($dateRange) !== 2) {
                $notify[] = ['error', 'Invalid Date Range Format'];
            } else {
                $formattedDates = array_map(function ($date) {
                    return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
                }, $dateRange);

                if (!strtotime($formattedDates[0]) || !strtotime($formattedDates[1])) {
                    $notify[] = ['error', 'Invalid Date Format'];
                }

                if (empty($notify)) {
                    $perdayEarnings = EarningLog::with('ad')
                        ->wherePublisherId(auth()->guard('publisher')->id())
                        ->whereBetween('created_at', $formattedDates)
                        ->paginate(getPaginate());
                }
            }
        } else {
            $notify[] = ['error', 'Invalid Date'];
        }

        if (!empty($notify)) {
            return back()->withNotify($notify);
        }

        return view($this->activeTemplate . 'publisher.advertises.earning', compact('pageTitle', 'perdayEarnings'));
    }






}
