<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('core')->group(function () {
    Route::prefix('geo')->group(function () {
        Route::post('cities', [\App\Http\Controllers\Api\Core\GeoController::class, 'cities']);
        Route::get('cities/{postal}', [\App\Http\Controllers\Api\Core\GeoController::class, 'citiesByPostal']);
    });

    Route::prefix('agency')->group(function () {
        Route::get('{agency_id}', [\App\Http\Controllers\Api\Core\AgencyController::class, 'info']);
        Route::put('{agency_id}', [\App\Http\Controllers\Api\Core\AgencyController::class, 'update']);
        Route::delete('{agency_id}', [\App\Http\Controllers\Api\Core\AgencyController::class, 'delete']);
    });

    Route::prefix('reseller')->group(function () {
        Route::get("{reseller_id}", [\App\Http\Controllers\Api\Core\ResellerController::class, 'get']);
        Route::delete("{reseller_id}", [\App\Http\Controllers\Api\Core\ResellerController::class, 'delete']);
    });

    Route::post('/document', [\App\Http\Controllers\Api\Core\DocumentController::class, 'upload']);
});
