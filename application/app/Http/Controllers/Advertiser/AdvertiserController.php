<?php

namespace App\Http\Controllers\Advertiser;

use App\Models\Plan;
use App\Models\Deposit;
use App\Models\CreateAd;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;

class AdvertiserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->guard('advertiser')->user();
        $widget['total_ads'] = CreateAd::where('advertiser_id',$user->id)->count();
        $widget['total_imp'] = CreateAd::where('advertiser_id',$user->id)->sum('impression');
        $widget['total_click'] = CreateAd::where('advertiser_id',$user->id)->sum('clicked');
        $widget['balance'] = $user->balance;

        // $remain_clcik = Purchase::where('advertiser_id', $user->id)->where('type','click')->first();
        // $remain_impression = Purchase::where('advertiser_id', $user->id)->where('type','impression')->first();

        $widget['remain_imp_point'] =   auth()->guard('advertiser')->user()->impression ?? 0;
        $widget['remain_click_point'] = auth()->guard('advertiser')->user()->click ?? 0;


        // Monthly Deposit & Withdraw Report Graph
       $deposits = Deposit::where('user_id',$user->id)->selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
       ->whereYear('created_at', date('Y'))
       ->whereStatus(1)
       ->groupBy('month_name', 'month_num')
       ->orderBy('month_num')
       ->get();
        $depositsChart['labels'] = $deposits->pluck('month_name');
        $depositsChart['values'] = $deposits->pluck('amount');

        // Monthly transaction
       $trx = Transaction::where('user_id',$user->id)->selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
       ->whereYear('created_at', date('Y'))
       ->groupBy('month_name', 'month_num')
       ->orderBy('month_num')
       ->get();
        $trxChart['labels'] = $trx->pluck('month_name');
        $trxChart['values'] = $trx->pluck('amount');

        return view($this->activeTemplate . 'advertiser.dashboard', compact('pageTitle','widget','depositsChart','trxChart'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->guard('advertiser')->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx',$request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'advertiser.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->guard('advertiser')->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate.'advertiser.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->guard('advertiser')->user();
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

        $user = auth()->guard('advertiser')->user();
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
        $transactions = Transaction::where('user_id',auth()->guard('advertiser')->id());

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
        return view($this->activeTemplate.'advertiser.transactions', compact('pageTitle','transactions','remarks'));
    }

    public function getPlans(){
        $pageTitle = 'All Plans';
        $plans = Plan::active()->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'advertiser.plan.index',compact('pageTitle','plans'));
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name).'- attachments.'.$extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->guard('advertiser')->user();
        if ($user->reg_step == 1) {
            return to_route('advertiser.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate.'advertiser.user_data', compact('pageTitle','user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->guard('advertiser')->user();
        if ($user->reg_step == 1) {
            return to_route('advertiser.home');
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
        return to_route('advertiser.home')->withNotify($notify);

    }

    public function perDay(Request $request)
    {
        $pageTitle = 'Day to Day logs';
        $transactions = Transaction::whereUserId(auth()->guard('advertiser')->user()->id)->paginate(15);
        return view($this->activeTemplate .'advertiser.ads.per_day',compact('transactions','pageTitle'));
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
                    $transactions = Transaction:: where('user_id',auth()->guard('advertiser')->id())
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

        return view($this->activeTemplate .'advertiser.ads.per_day',compact('transactions','pageTitle'));
    }

}
