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

Route::get('/redirect', [\App\Http\Controllers\HomeController::class, 'redirect']);

Route::get('/register/welcome', [\App\Http\Controllers\Auth\RegisterController::class, 'firstStep'])->name('auth.register.firstStep');
Route::get('/register/package', [\App\Http\Controllers\Auth\RegisterController::class, 'package'])->name('auth.register.package');
Route::get('/register/card', [\App\Http\Controllers\Auth\RegisterController::class, 'card'])->name('auth.register.card');
Route::get('/register/cart', [\App\Http\Controllers\Auth\RegisterController::class, 'cart'])->name('auth.register.cart');

Route::get('/register/suivre', [\App\Http\Controllers\Auth\RegisterController::class, 'suivi'])->name('auth.register.suivi');

Route::prefix('register/personnal')->group(function () {
    Route::get('/home', [\App\Http\Controllers\Auth\RegisterController::class, 'home'])->name('auth.register.personnal.home');
    Route::get('/pro', [\App\Http\Controllers\Auth\RegisterController::class, 'pro'])->name('auth.register.personnal.pro');
    Route::get('/recap', [\App\Http\Controllers\Auth\RegisterController::class, 'recap'])->name('auth.register.personnal.recap');
    Route::get('/signate', [\App\Http\Controllers\Auth\RegisterController::class, 'signate'])->name('auth.register.personnal.signate');
    Route::get('/document', [\App\Http\Controllers\Auth\RegisterController::class, 'document'])->name('auth.register.personnal.document');
    Route::get('/identity', [\App\Http\Controllers\Auth\RegisterController::class, 'identity'])->name('auth.register.personnal.identity');
    Route::get('/terminate', [\App\Http\Controllers\Auth\RegisterController::class, 'terminate'])->name('auth.register.personnal.terminate');
});

Route::prefix('register/pro')->group(function () {
    Route::get('/home', [\App\Http\Controllers\Auth\RegisterProController::class, 'home'])->name('auth.register.pro.home');
    Route::get('/options', [\App\Http\Controllers\Auth\RegisterProController::class, 'options'])->name('auth.register.pro.options');
    Route::get('/recap', [\App\Http\Controllers\Auth\RegisterProController::class, 'recap'])->name('auth.register.pro.recap');
    Route::get('/signate', [\App\Http\Controllers\Auth\RegisterProController::class, 'signate'])->name('auth.register.pro.signate');
    Route::get('/document', [\App\Http\Controllers\Auth\RegisterProController::class, 'document'])->name('auth.register.pro.document');
    Route::get('/terminate', [\App\Http\Controllers\Auth\RegisterProController::class, 'terminate'])->name('auth.register.pro.terminate');
});

Route::prefix('auth')->group(function () {
    Route::get('/register', [\App\Http\Controllers\Auth\TwilioController::class, 'register'])->name('auth.verify.register');
    Route::get("/verify", [\App\Http\Controllers\Auth\TwilioController::class, 'verifyView'])->name('auth.verify.view');
    Route::post("/verify", [\App\Http\Controllers\Auth\TwilioController::class, 'verify'])->name('auth.verify.check');
});
