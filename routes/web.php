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

include('auth.php');
include('front.php');
include('admin.php');
include('agent.php');
include('customer.php');

Route::prefix('signate')->group(function () {
    Route::get('{token}', [\App\Http\Controllers\Signate\SignateController::class, 'show'])->name('signate.show');
    Route::post('{token}', [\App\Http\Controllers\Signate\SignateController::class, 'signate'])->name('signate');
});

Route::prefix('verify')->group(function () {
    Route::get('/verify-mail', [\App\Http\Controllers\VerifyController::class, 'mail'])->name('verify-mail');
    Route::get('/verify-identity', [\App\Http\Controllers\VerifyController::class, 'identity'])->name('verify-identity');
    Route::get('/verify-address', [\App\Http\Controllers\VerifyController::class, 'address'])->name('verify-address');
    Route::get('/verify-income', [\App\Http\Controllers\VerifyController::class, 'income'])->name('verify-income');
    Route::get('/verify-other', [\App\Http\Controllers\VerifyController::class, 'other'])->name('verify-other');

    Route::get('/verify-success', [\App\Http\Controllers\VerifyController::class, 'success'])->name('verify-success');
    Route::get('/verify-error', [\App\Http\Controllers\VerifyController::class, 'error'])->name('verify-error');
});

Route::prefix('stripe')->group(function () {
    Route::get('/cancel', [\App\Http\Controllers\StripeController::class, 'cancel'])->name('stripe.cancel');
    Route::get('/success', [\App\Http\Controllers\StripeController::class, 'success'])->name('stripe.success');
});

Route::prefix('powens')->group(function () {
    Route::get('webview', [\App\Http\Controllers\PowensController::class, 'webview'])->name('powens.webview');
    Route::get('webview/success', [\App\Http\Controllers\PowensController::class, 'success'])->name('powens.success');
});

Auth::routes();
Route::mailweb();

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');
Route::get('/test', [\App\Http\Controllers\HomeController::class, 'test']);
Route::post('/push', [\App\Http\Controllers\HomeController::class, 'push'])->middleware(['auth']);
