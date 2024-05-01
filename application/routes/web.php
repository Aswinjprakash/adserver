<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

    //authorization
    Route::controller('AuthorizationController')->group(function(){
        Route::get('authorization/{guard}', 'authorizeForm')->name('authorization');
        Route::get('resend/verify/{type}/{guard}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify/email/{guard}', 'emailVerification')->name('verify.email');
        Route::post('verify/mobile/{guard}', 'mobileVerification')->name('verify.mobile');
        Route::post('verify/g2fa/{guard}', 'g2faVerification')->name('go2fa.verify');
    });

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');


Route::controller('VisitorController')->group(function () {
    Route::get('/ads/{publisher}/{type}/{current}', 'getAdvertise')->name('adsUrl');
    Route::get('/ad-clicked/{publisher}/{track_id}', 'adClicked')->name('adClicked');
});

Route::controller('SiteController')->group(function () {

    // login and registration
    Route::get('/login', 'showLoginForm')->name('login');
    Route::get('register', 'showRegistrationForm')->name('register');

     //advertiser login and registration
     Route::get('advertiser/login', 'showadvertiserLoginForm')->name('advertiser.login');
     Route::get('/advertiser/register', 'showadvertiserRegistrationForm')->name('advertiser.register');


    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    // subscriber
    Route::post('/subscribe','subscribe')->name('subscribe');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});


