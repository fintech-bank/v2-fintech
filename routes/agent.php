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
    });
});
