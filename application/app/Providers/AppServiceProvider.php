<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Advertiser;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\SupportTicket;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $general = gs();
        $activeTemplate = activeTemplate();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['emptyMessage'] = 'No data';
        view()->share($viewShare);


        view()->composer('admin.components.tabs.advertisers', function ($view) {
            $view->with([
                'bannedUsersCount'           => Advertiser::banned()->count(),
                'emailUnverifiedUsersCount' => Advertiser::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => Advertiser::mobileUnverified()->count(),

            ]);
        });
        view()->composer('admin.components.tabs.publishers', function ($view) {
            $view->with([
                'publisherBannedUsersCount'           => Publisher::banned()->count(),
                'publisherMailUnverifiedUsersCount' => Publisher::emailUnverified()->count(),
                'publisherMobileUnverifiedUsersCount'   => Publisher::mobileUnverified()->count(),

            ]);
        });
        view()->composer('admin.components.tabs.deposit', function ($view) {
            $view->with([
                'pendingDepositsCount'    => Deposit::pending()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.withdrawal', function ($view) {
            $view->with([
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.ticket', function ($view) {
            $view->with([
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0,2])->count(),
            ]);
        });
        view()->composer('admin.components.sidenav', function ($view) {
            $view->with([
                'publisherBannedUsersCount'           => Advertiser::banned()->count(),
                'publisherMailUnverifiedUsersCount' => Advertiser::emailUnverified()->count(),
                'publisherMobileUnverifiedUsersCount'   => Advertiser::mobileUnverified()->count(),
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0,2])->count(),
                'pendingDepositsCount'    => Deposit::pending()->count(),
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
            ]);
        });

        view()->composer('admin.components.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'           => Advertiser::banned()->count(),
                'emailUnverifiedUsersCount' => Advertiser::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => Advertiser::mobileUnverified()->count(),
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0,2])->count(),
                'pendingDepositsCount'    => Deposit::pending()->count(),
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
            ]);
        });

        view()->composer('admin.components.topnav', function ($view) {
            $view->with([
                'adminNotifications'=>AdminNotification::where('read_status',0)->with('user')->orderBy('id','desc')->take(10)->get(),
                'adminNotificationCount'=>AdminNotification::where('read_status',0)->count(),
            ]);
        });

        view()->composer('includes.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if($general->force_ssl){
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFour();
    }
}
