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

Route::prefix('customer')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Agent\HomeController::class, 'index'])->name('customer.dashboard');

    Route::prefix('account')->group(function () {
        Route::prefix('notify')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Account\NotifyController::class, 'index'])->name('customer.account.notify.index');
            Route::get('/{notify_id}', [\App\Http\Controllers\Agent\Account\NotifyController::class, 'show'])->name('customer.account.notify.show');
        });

        Route::prefix('mailbox')->group(function () {
            Route::get("{folder?}", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'index'])->name('customer.account.mailbox.index');
            Route::get("create", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'create'])->name('customer.account.mailbox.create');
            Route::post("create", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'store'])->name('customer.account.mailbox.store');
            Route::get("message/{id}", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'show'])->name('customer.account.mailbox.show');
            Route::put("toggle-important", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'toggleImportant'])->name('customer.account.mailbox.toggleImportant');
            Route::delete("/", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'trash'])->name('customer.account.mailbox.trash');
            Route::get("message/{id}/reply", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'getReply'])->name('customer.account.mailbox.getReply');
            Route::post("message/{id}/reply", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'postReply'])->name('customer.account.mailbox.postReply');
            Route::get("message/{id}/forward", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'getForward'])->name('customer.account.mailbox.getForward');
            Route::post("message/{id}/forward", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'postForward'])->name('customer.account.mailbox.postForward');
            Route::get("message/{id}/send", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'send'])->name('customer.account.mailbox.send');
        });

        Route::prefix('documents')->group(function () {
            Route::get("/", [\App\Http\Controllers\Agent\Account\DocumentsController::class, 'index'])->name('customer.account.documents.index');
        });

        Route::prefix('profil')->group(function () {
            Route::get("/", [\App\Http\Controllers\Agent\Account\ProfilController::class, 'index'])->name('customer.account.profil.index');
        });
    });
});
