<?php

Route::namespace('Publisher\Auth')->name('publisher.')->group(function () {

    Route::controller('LoginController')->group(function(){
        Route::post('/login', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function(){
        Route::post('register', 'register')->name('register')->middleware('registration.status');
        Route::post('check-mail', 'checkPublisher')->name('checkPublisher');
    });

    Route::controller('ForgotPasswordController')->group(function(){
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });

    Route::controller('ResetPasswordController')->group(function(){
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });


});


Route::name('publisher.')->group(function () {
    //authorization

    Route::middleware(['check.status:publisher'])->group(function () {

        Route::get('user/data', 'Publisher\PublisherController@userData')->name('data');
        Route::post('user/data/submit', 'Publisher\PublisherController@userDataSubmit')->name('data.submit');

        Route::namespace('Publisher')->middleware('registration.complete:publisher')->group(function () {

            Route::controller('PublisherController')->group(function(){
                Route::get('dashboard', 'dashboard')->name('home');

                 // //2FA
                 Route::get('twofactor', 'show2faForm')->name('twofactor');
                 Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                 Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                 // //Report
                 Route::get('transactions','transactions')->name('transactions');
                 Route::get('attachment-download/{fil_hash}','attachmentDownload')->name('attachment.download');

                //  domain
                Route::get('domain-lists','getDomain')->name('domain.index');
                Route::post('domain-store','domainStore')->name('domain.store');
                Route::get('domain/{tracker}/verification','domainVerifyAct')->name('domain.verify.action');
                Route::get('domain/check/{tracker}','domainCheck')->name('domain.check');
                Route::get('domain/edit/{id}','editDomainKeyword')->name('domain.edit');
                Route::post('domain/update/{id}','updateDomainKeyword')->name('domain.update');
                Route::post('domain/delete','domainDelete')->name('domain.delete');

                // report
                Route::get('published/per-day/ad-log', 'publishedPerdayAd')->name('published.perday.ad');
                Route::get('published/per-day/earning-log', 'earningLog')->name('published.perday.earning');
                Route::get('date-to-date/spent/logs/search', 'adReportSearch')->name('report.date.search');
                Route::get('date-to-date/day/earning/search', 'adReportEarning')->name('report.day.earning.search');




            });

               //Profile setting
               Route::controller('ProfileController')->group(function(){
                Route::get('profile/setting', 'profile')->name('profile.setting');
                Route::post('profile/setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::post('profile-image/updat6e', 'imageUpdate')->name('profile.image.update');
            });

              //Profile setting
              Route::controller('AdvertiseController')->group(function(){
                Route::get('advertisements', 'advertises')->name('advertises');
                Route::get('published/ad', 'publishedAd')->name('published.ad');

            });

        });


    });
});

          // Payment
     Route::middleware(['check.status:publisher'])->name('user.withdraw')->prefix('publisher/withdraw')->group(function () {
        Route::middleware('registration.complete:publisher')->controller('Publisher\WithdrawController')->group(function(){
            Route::get('/', 'withdrawMoney');
            Route::post('/', 'withdrawStore')->name('.money');
            Route::get('preview', 'withdrawPreview')->name('.preview');
            Route::post('preview', 'withdrawSubmit')->name('.submit');
            Route::get('history', 'withdrawLog')->name('.history');
        });
    });


