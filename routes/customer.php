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

Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', \App\Http\Controllers\Customer\HomeController::class)->name('dashboard');

    Route::prefix('account')->name('account.')->group(function () {
        Route::prefix('notify')->name('notify.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Account\NotifyController::class, 'index'])->name('index');
            Route::get('/{notify_id}', [\App\Http\Controllers\Customer\Account\NotifyController::class, 'show'])->name('show');
        });

        Route::prefix('mailbox')->name('mailbox.')->group(function () {
            Route::get("{folder?}", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'index'])->name('index');
            Route::get("create", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'create'])->name('create');
            Route::post("create", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'store'])->name('store');
            Route::get("message/{id}", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'show'])->name('show');
            Route::put("toggle-important", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'toggleImportant'])->name('toggleImportant');
            Route::delete("/", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'trash'])->name('trash');
            Route::get("message/{id}/reply", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'getReply'])->name('getReply');
            Route::post("message/{id}/reply", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'postReply'])->name('postReply');
            Route::get("message/{id}/forward", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'getForward'])->name('getForward');
            Route::post("message/{id}/forward", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'postForward'])->name('postForward');
            Route::get("message/{id}/send", [\App\Http\Controllers\Customer\Account\MailboxController::class, 'send'])->name('send');
        });

        Route::prefix('agenda')->name('agenda.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Account\AgendaController::class, 'index'])->name('index');
            Route::get('{id}', [\App\Http\Controllers\Customer\Account\AgendaController::class, 'show'])->name('show');
        });

        Route::prefix('documents')->name('documents.')->group(function () {
            Route::get("/", [\App\Http\Controllers\Customer\Account\Document\DocumentController::class, 'index'])->name('index');
            Route::get("category/{category_id}", [\App\Http\Controllers\Customer\Account\Document\DocumentController::class, 'category'])->name('category');

            Route::prefix('externe')->name('externe.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Customer\Account\Document\DocumentExterneController::class, 'index'])->name('index');
            });

            Route::prefix('request')->name('request.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Customer\Account\Document\DocumentRequestController::class, 'index'])->name('index');
                Route::get('{reference}', [\App\Http\Controllers\Customer\Account\Document\DocumentRequestController::class, 'show'])->name('show');
            });
        });

        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get("/", [\App\Http\Controllers\Agent\Account\ProfilController::class, 'index'])->name('index');

            Route::prefix('security')->name('security.')->group(function () {
                Route::get('/', \App\Http\Controllers\Customer\Profil\Security\SecurityController::class)->name('index');
            });

            Route::prefix('identity')->name('identity.')->group(function () {
                Route::get('/', \App\Http\Controllers\Customer\Profil\Identity\IdentityController::class)->name('index');
            });

            Route::prefix('contact')->name("contact.")->group(function () {
                Route::get('/', \App\Http\Controllers\Customer\Profil\Contact\ContactController::class)->name('index');
            });
            Route::prefix('grpd')->name("grpd.")->group(function () {
                Route::get('/', [\App\Http\Controllers\Customer\Profil\Contact\GrpdController::class, 'index'])->name('index');
            });
            Route::prefix('secret')->name("secret.")->group(function () {
                Route::get('/', [\App\Http\Controllers\Customer\Profil\Security\SecurityController::class, 'index'])->name('index');
            });

            Route::prefix('cashback')->name('cashback.')->group(function () {
                Route::get('/', \App\Http\Controllers\Customer\Profil\CashbackController::class)->name('index');
            });

            Route::prefix('sponsorship')->name('sponsorship.')->group(function () {
                Route::get('/', \App\Http\Controllers\Customer\Profil\SponsorshipController::class)->name('index');
            });

            Route::prefix('mobility')->name('mobility.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Customer\Profil\MobilityController::class, 'index'])->name('index');
            });

            Route::prefix('transfer')->name('transfer.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Customer\Profil\TransferAgencyController::class, 'index'])->name('index');
            });

            Route::prefix('paystar')->name('paystar.')->group(function () {
                Route::get('/', \App\Http\Controllers\Customer\Profil\PaystarController::class)->name('index');
            });
        });
    });
    Route::prefix('compte')->name('compte.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\Compte\CompteController::class, 'index'])->name('index');
        Route::get('{wallet_uuid}', [\App\Http\Controllers\Customer\Compte\CompteController::class, 'wallet'])->name('wallet');

        Route::prefix('card')->name('card.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Compte\CardController::class, 'index'])->name('index');
        });

        Route::prefix('transfer')->name('transfer.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Compte\TransferController::class, 'index'])->name('index');
        });

        Route::prefix('sepa')->name('sepa.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Compte\SepaController::class, 'index'])->name('index');
        });

        Route::prefix('budgets')->name('budgets.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Compte\BudgetsController::class, 'index'])->name('index');
        });

        Route::prefix('offers')->name('offers.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Compte\OffersController::class, 'index'])->name('index');
        });
    });
    Route::prefix('pret')->group(function () {
        Route::get('/', \App\Http\Controllers\Customer\Pret\PretController::class)->name('customer.pret');

        Route::prefix('perso')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Pret\PretPersoController::class, 'index'])->name('customer.pret.perso');
        });

        Route::prefix('immo')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\Pret\PretImmoController::class, 'index'])->name('customer.pret.immo');
        });
    });
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('/', \App\Http\Controllers\Customer\Contact\ContactController::class)->name('index');
    });
});
