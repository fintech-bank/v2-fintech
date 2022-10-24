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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/ship/suivi', [\App\Http\Controllers\HomeController::class, 'shipping'])->name('shipping');

Route::prefix('particulier')->group(function () {
    Route::get('/', [\App\Http\Controllers\Front\Particulier\HomeController::class, 'index'])->name('part.home');
});
