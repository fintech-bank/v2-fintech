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

Route::prefix('agence')->middleware(['auth', 'agent'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Agent\HomeController::class, 'index'])->name('agent.dashboard');

    Route::prefix('account')->group(function () {
        Route::prefix('notify')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Account\NotifyController::class, 'index'])->name('agent.account.notify.index');
            Route::get('/{notify_id}', [\App\Http\Controllers\Agent\Account\NotifyController::class, 'show'])->name('agent.account.notify.show');
        });

        Route::prefix('mailbox')->group(function () {
            Route::get("{folder?}", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'index'])->name('agent.account.mailbox.index');
            Route::get("create", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'create'])->name('agent.account.mailbox.create');
            Route::post("create", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'store'])->name('agent.account.mailbox.store');
            Route::get("message/{id}", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'show'])->name('agent.account.mailbox.show');
            Route::put("toggle-important", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'toggleImportant'])->name('agent.account.mailbox.toggleImportant');
            Route::delete("/", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'trash'])->name('agent.account.mailbox.trash');
            Route::get("message/{id}/reply", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'getReply'])->name('agent.account.mailbox.getReply');
            Route::post("message/{id}/reply", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'postReply'])->name('agent.account.mailbox.postReply');
            Route::get("message/{id}/forward", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'getForward'])->name('agent.account.mailbox.getForward');
            Route::post("message/{id}/forward", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'postForward'])->name('agent.account.mailbox.postForward');
            Route::get("message/{id}/send", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'send'])->name('agent.account.mailbox.send');
        });

        Route::prefix('documents')->group(function () {
            Route::get("/", [\App\Http\Controllers\Agent\Account\DocumentsController::class, 'index'])->name('agent.account.documents.index');
        });

        Route::prefix('agenda')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Account\EventController::class, 'index'])->name('agent.account.agenda.index');
            Route::post('/', [\App\Http\Controllers\Agent\Account\EventController::class, 'store'])->name('agent.account.agenda.store');
        });

        Route::prefix('profil')->group(function () {
            Route::get("/", [\App\Http\Controllers\Agent\Account\ProfilController::class, 'index'])->name('agent.account.profil.index');
        });
    });

    Route::prefix('customer')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'index'])->name('agent.customer.index');
        Route::get('{id}', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'show'])->name('agent.customer.show');
        Route::put('{id}', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'update'])->name('agent.customer.update');
        Route::prefix('{customer_id}')->group(function () {
            Route::get('pret', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'createPret'])->name('agent.customer.pret');
        });
        Route::prefix('create')->group(function() {
            Route::get('start', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'start'])->name('agent.customer.create.start');
            Route::post('subscribe', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'subscribe']);

            Route::prefix('part')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'info'])->name('agent.customer.create.part.info');
                Route::get('pro', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'pro'])->name('agent.customer.create.part.pro');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'package'])->name('agent.customer.create.part.package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'card'])->name('agent.customer.create.part.card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreatePartCustomerController::class, 'options'])->name('agent.customer.create.part.options');
            });

            Route::prefix('pro')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'index'])->name('agent.customer.create.pro.info');
                Route::get('signataire', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'signataire'])->name('agent.customer.create.pro.signataire');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'package'])->name('agent.customer.create.pro.package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'card'])->name('agent.customer.create.pro.card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'options'])->name('agent.customer.create.pro.options');
            });

            Route::prefix('orga')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'index'])->name('agent.customer.create.orga.info');
                Route::get('signataire', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'signataire'])->name('agent.customer.create.orga.signataire');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'package'])->name('agent.customer.create.orga.package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'card'])->name('agent.customer.create.orga.card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreateOrgaCustomerController::class, 'options'])->name('agent.customer.create.orga.options');
            });

            Route::prefix('assoc')->group(function () {
                Route::get('info', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'index'])->name('agent.customer.create.assoc.info');
                Route::get('signataire', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'signataire'])->name('agent.customer.create.assoc.signataire');
                Route::get('package', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'package'])->name('agent.customer.create.assoc.package');
                Route::get('card', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'card'])->name('agent.customer.create.assoc.card');
                Route::get('options', [\App\Http\Controllers\Agent\Customer\CreateProCustomerController::class, 'options'])->name('agent.customer.create.assoc.options');
            });

            Route::get('finish', [\App\Http\Controllers\Agent\Customer\CustomerController::class, 'finish'])->name('agent.customer.create.finish');
        });
        Route::prefix('wallet')->group(function () {
            Route::get('{number_account}', [\App\Http\Controllers\Agent\Customer\CustomerWalletController::class, 'show'])->name('agent.customer.wallet.show');

            Route::prefix('{number_account}/card')->group(function () {
                Route::get('/{card_id}', [\App\Http\Controllers\Agent\Customer\CreditCardController::class, 'index'])->name('agent.customer.wallet.card');
                Route::get('/{card_id}/facelia', [\App\Http\Controllers\Agent\Customer\CreditCardController::class, 'facelia'])->name('agent.customer.wallet.card.facelia');
            });
        });
    });
});
