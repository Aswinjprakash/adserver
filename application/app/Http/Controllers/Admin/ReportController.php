<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function advertiserTransaction(Request $request)
    {
        $pageTitle = 'Transaction Logs';

        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::with('advertiser')->orderBy('id','desc');
        if ($request->search) {
            $search = request()->search;
            $transactions = $transactions->where(function ($q) use ($search) {
                $q->where('trx', 'like', "%$search%")->orWhereHas('advertiser', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
            });
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type',$request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark',$request->remark);
        }

        //date search
        if($request->date) {
            $date = explode('-',$request->date);
            $request->merge([
                'start_date'=> trim(@$date[0]),
                'end_date'  => trim(@$date[1])
            ]);
            $request->validate([
                'start_date'    => 'required|date_format:m/d/Y',
                'end_date'      => 'nullable|date_format:m/d/Y'
            ]);
            if($request->end_date) {
                $endDate = Carbon::parse($request->end_date)->addHours(23)->addMinutes(59)->addSecond(59);
                $transactions   = $transactions->whereBetween('created_at', [Carbon::parse($request->start_date), $endDate]);
            }else{
                $transactions   = $transactions->whereDate('created_at', Carbon::parse($request->start_date));
            }
        }

        $transactions = $transactions->paginate(getPaginate());
        return view('admin.reports.advertiser_transactions', compact('pageTitle', 'transactions','remarks'));
    }


    public function publisherTransaction(Request $request)
    {
        $pageTitle = 'Transaction Logs';

        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::with('publisher')->orderBy('id','desc');
        if ($request->search) {
            $search = request()->search;
            $transactions = $transactions->where(function ($q) use ($search) {
                $q->where('trx', 'like', "%$search%")->orWhereHas('publisher', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
            });
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type',$request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark',$request->remark);
        }

        //date search
        if($request->date) {
            $date = explode('-',$request->date);
            $request->merge([
                'start_date'=> trim(@$date[0]),
                'end_date'  => trim(@$date[1])
            ]);
            $request->validate([
                'start_date'    => 'required|date_format:m/d/Y',
                'end_date'      => 'nullable|date_format:m/d/Y'
            ]);
            if($request->end_date) {
                $endDate = Carbon::parse($request->end_date)->addHours(23)->addMinutes(59)->addSecond(59);
                $transactions   = $transactions->whereBetween('created_at', [Carbon::parse($request->start_date), $endDate]);
            }else{
                $transactions   = $transactions->whereDate('created_at', Carbon::parse($request->start_date));
            }
        }

        $transactions = $transactions->paginate(getPaginate());
        return view('admin.reports.publisher_transactions', compact('pageTitle', 'transactions','remarks'));
    }


    public function advertiserLoginHistory(Request $request)
    {
        $loginLogs = UserLogin::orderBy('id','desc')->with('advertiser')->paginate(getPaginate());

        $pageTitle = 'User Login History';

        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'User Login History - ' . $search;
            $loginLogs = UserLogin::whereHas('advertiser', function ($query) use ($search) {
                $query->where('username', $search);
            })->with('advertiser')->orderBy('id','desc')->paginate(getPaginate());
        }

        return view('admin.reports.advertiser_logins', compact('pageTitle', 'loginLogs'));
    }

    public function publisherLoginHistory(Request $request)
    {
        $loginLogs = UserLogin::orderBy('id','desc')->with('publisher')->paginate(getPaginate());

        $pageTitle = 'User Login History';

        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'User Login History - ' . $search;
            $loginLogs = UserLogin::whereHas('publisher', function ($query) use ($search) {
                $query->where('username', $search);
            })->with('publisher')->orderBy('id','desc')->paginate(getPaginate());
        }

        return view('admin.reports.publisher_logins', compact('pageTitle', 'loginLogs'));
    }


    public function advertiserLoginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('advertiser')->paginate(getPaginate());
        return view('admin.reports.advertiser_logins', compact('pageTitle', 'loginLogs','ip'));
    }
    public function publisherLoginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('publisher')->paginate(getPaginate());
        return view('admin.reports.publisher_logins', compact('pageTitle', 'loginLogs','ip'));
    }

    public function advertiserNotificationHistory(Request $request) {
        $pageTitle = 'Notification History';

        $search = $request->search;

        // Get the notification logs with matching advertiser information
        $logs = NotificationLog::select('notification_logs.*')
            ->join('advertisers', 'notification_logs.user_id', '=', 'advertisers.id')
            ->when($search, function ($query) use ($search) {
                return $query->where('advertisers.username', 'like', "%$search%");
            })
            ->orderBy('notification_logs.id', 'desc')
            ->paginate(getPaginate());

        return view('admin.reports.advertiser_notification_history', compact('pageTitle', 'logs'));
    }


    public function publisherNotificationHistory(Request $request){

        $pageTitle = 'Notification History';
        $search = $request->search;
        // Get the notification logs with matching advertiser information
        $logs = NotificationLog::select('notification_logs.*')
            ->join('publishers', 'notification_logs.user_id', '=', 'publishers.id')
            ->when($search, function ($query) use ($search) {
                return $query->where('publishers.username', 'like', "%$search%");
            })
            ->orderBy('notification_logs.id', 'desc')
            ->paginate(getPaginate());
        return view('admin.reports.publisher_notification_history', compact('pageTitle','logs'));
    }


    public function emailDetails($id){
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle','email'));
    }
}
