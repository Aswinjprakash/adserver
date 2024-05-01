<?php


Route::namespace('Advertiser\Auth')->name('advertiser.')->group(function () {

    Route::controller('LoginController')->group(function(){
        Route::post('/login', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function(){
        Route::post('register', 'register')->name('register')->middleware('registration.status');
        Route::post('check-mail', 'checkAdvertiser')->name('checkAdvertiser');
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




    Route::middleware(['check.status:advertiser'])->name('advertiser.')->group(function () {

        Route::get('advertiser/data', 'Advertiser\AdvertiserController@userData')->name('data');
        Route::post('advertiser/data/submit', 'Advertiser\AdvertiserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete:advertiser')->namespace('Advertiser')->group(function () {

            Route::controller('AdvertiserController')->group(function(){
                Route::get('dashboard', 'home')->name('home');

                // //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                // //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions','transactions')->name('transactions');

                Route::get('attachment-download/{fil_hash}','attachmentDownload')->name('attachment.download');

                // plan
                Route::get('plans','getPlans')->name('get.plan');

                // per day log
                Route::get('per-day/reports', 'perDay')->name('perday.report');
                Route::get('date-to-date/spent/logs/search', 'adReportSearch')->name('report.date.search');



            });

            //Profile setting
            Route::controller('ProfileController')->group(function(){
                Route::get('profile/setting', 'profile')->name('profile.setting');
                Route::post('profile/setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');

                Route::post('profile-image/updat6e', 'imageUpdate')->name('profile.image.update');
            });

             //Ad setting
             Route::controller('AdController')->name('ad.')->prefix('ad')->group(function(){
                Route::get('', 'index')->name('index');
                Route::get('types', 'getAdTypes')->name('types');
                Route::get('create/{id}', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::post('delete', 'delete')->name('delete');

                // update stataus
                Route::post('update-status', 'updateStatus')->name('update.status');

                Route::get('ad-report/', 'adReport')->name('report');
                Route::get('ad/logs/search', 'adReportSearch')->name('report.search');


            });
        });
    });

     // Payment
     Route::middleware(['check.status:advertiser'])->name('user.')->group(function () {
        Route::middleware('registration.complete:advertiser')->controller('Gateway\PaymentController')->group(function(){
            Route::get('payment/{id}', 'payment')->name('payment');
            Route::any('/deposit', 'deposit')->name('deposit');
            Route::post('deposit/insert', 'depositInsert')->name('deposit.insert');
            Route::get('deposit/confirm', 'depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'manualDepositUpdate')->name('deposit.manual.update');
        });
    });

