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

Route::prefix('signate')->group(function () {
    Route::get('{token}', [\App\Http\Controllers\Signate\SignateController::class, 'show'])->name('signate.show');
    Route::post('{token}', [\App\Http\Controllers\Signate\SignateController::class, 'signate'])->name('signate');
});

Auth::routes();
Route::mailweb();

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');
Route::get('/test', [\App\Http\Controllers\HomeController::class, 'test']);
Route::post('/push', [\App\Http\Controllers\HomeController::class, 'push'])->middleware(['auth']);
