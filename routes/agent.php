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
            Route::get("/", [\App\Http\Controllers\Agent\Account\MailboxController::class, 'index'])->name('agent.account.mailbox.index');
        });

        Route::prefix('documents')->group(function () {
            Route::get("/", [\App\Http\Controllers\Agent\Account\DocumentsController::class, 'index'])->name('agent.account.documents.index');
        });

        Route::prefix('profil')->group(function () {
            Route::get("/", [\App\Http\Controllers\Agent\Account\ProfilController::class, 'index'])->name('agent.account.profil.index');
        });
    });
});
