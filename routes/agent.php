<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('agence')->name('agent.')->middleware(['auth', 'agent'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Agent\HomeController::class, 'index'])->name('dashboard');

    Route::prefix('account')->name('account.')->group(function () {
        Route::prefix('notify')->name('notify.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Account\NotifyController::class, 'index'])->name('index');
            Route::get('{notify_id}', [\App\Http\Controllers\Agent\Account\NotifyController::class, 'show'])->name('show');
        });

        Route::prefix('mailbox')->name('mailbox.')->group(function () {
            Route::get("{folder?}", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'index'])->name('index');
            Route::get("create", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'create'])->name('create');
            Route::post("create", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'store'])->name('store');
            Route::get("message/{id}", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'show'])->name('show');
            Route::put("toggle-important", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'toggleImportant'])->name('toggleImportant');
            Route::delete("/", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'trash'])->name('trash');
            Route::get("message/{id}/reply", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'getReply'])->name('getReply');
            Route::post("message/{id}/reply", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'postReply'])->name('postReply');
            Route::get("message/{id}/forward", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'getForward'])->name('getForward');
            Route::post("message/{id}/forward", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'postForward'])->name('postForward');
            Route::get("message/{id}/send", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'send'])->name('send');
        });

        Route::prefix('documents')->name('documents.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Account\DocumentsController::class, 'index'])->name('index');
        });

        Route::prefix('agenda')->name('agenda.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Account\EventController::class, 'index'])->name('index');
            Route::post('/', [\App\Http\Controllers\Agent\Account\EventController::class, 'store'])->name('store');
        });

        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Account\ProfilController::class, 'index'])->name('index');
        });
    });

    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'index'])->name('index');

        Route::prefix('create')->name('create.')->group(function () {
            Route::get('start', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'start'])->name('start');
            Route::post('subscribe', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'subscribe'])->name('subscribe');

            Route::prefix('part')->name('part.')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'info'])->name('info');
                Route::get('pro', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'pro'])->name('pro');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'package'])->name('package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'card'])->name('card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'options'])->name('options');
            });

            Route::prefix('pro')->name('pro.')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'index'])->name('info');
                Route::get('signataire', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'signataire'])->name('signataire');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'package'])->name('package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'card'])->name('card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'options'])->name('options');
            });

            Route::prefix('orga')->name('orga.')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'index'])->name('info');
                Route::get('signataire', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'signataire'])->name('signataire');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'package'])->name('package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'card'])->name('card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'options'])->name('options');
            });

            Route::prefix('assoc')->name('assoc')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'index'])->name('info');
                Route::get('signataire', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'signataire'])->name('signataire');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'package'])->name('package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'card'])->name('card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'options'])->name('options');
            });

            Route::get('finish', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'finish'])->name('finish');
        });

        Route::prefix('{customer_id}')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'show'])->name('show');
            Route::put('/', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'update'])->name('update');
            Route::get('pret', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'createPret'])->name('pret');
            Route::post('pret', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'storePret'])->name('pret.store');
            Route::get('epargne', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'createEpargne'])->name('epargne');
        });

        Route::prefix('wallet')->name('wallet.')->group(function () {
            Route::get('{number_account}', [\App\Http\Controllers\Agent\Customer\CustomerWalletController::class, 'show'])->name('show');

            Route::prefix('{number_account}/card')->name('card.')->group(function () {
                Route::get('{card_id}', [\App\Http\Controllers\Agent\Customer\CreditCardController::class, 'index'])->name('index');
                Route::get('{card_id}/facelia', [\App\Http\Controllers\Agent\Customer\CreditCardController::class, 'facelia'])->name('facelia');
            });
        });
    });

    Route::prefix('credit')->name('credit.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Credit\CreditController::class, 'index'])->name('index');
    });

    Route::prefix('withdraw')->name('withdraw.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Withdraw\WithdrawController::class, 'index'])->name('index');
    });

    Route::prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Deposit\DepositController::class, 'index'])->name('index');
    });

    Route::prefix('insurance')->name('insurance.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Insurance\InsuranceController::class, 'index'])->name('index');
        Route::get('{reference}', [\App\Http\Controllers\Agent\Insurance\InsuranceController::class, 'show'])->name('show');

        Route::prefix('{reference}/claims')->name('claims.')->group(function () {
            Route::get('{claims_reference}', [\App\Http\Controllers\Agent\Insurance\ClaimController::class, 'show'])->name('show');
        });
    });

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Transaction\TransactionController::class, 'index'])->name('index');
    });

    Route::prefix('opposit')->name('opposit.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Opposit\OppositController::class, 'index'])->name('index');
    });

    Route::prefix('telecom')->name('telecom.')->group(function () {
        Route::prefix('internet')->name('internet.')->group(function () {

        });

        Route::prefix('phone')->name('phone.')->group(function () {

        });

        Route::prefix('mobile')->name('mobile.')->group(function () {

        });
    });
});
