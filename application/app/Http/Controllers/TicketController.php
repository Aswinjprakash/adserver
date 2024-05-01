<?php

namespace App\Http\Controllers;

use App\Traits\SupportTicketManager;

class TicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
        $this->layout = 'frontend';

        $this->middleware(function ($request, $next) {
        if (auth()->guard('advertiser')->user()) {
            $this->user = auth()->guard('advertiser')->user();
            if ($this->user) {
                $this->layout = 'advertiser.master';
            }
        }else{
            $this->user = auth()->guard('publisher')->user();
            if ($this->user) {
                $this->layout = 'publisher.master';
            }
        }
            return $next($request);
        });

        $this->redirectLink = 'ticket.view';
        $this->userType     = 'user';
        $this->column       = 'user_id';
    }
}
