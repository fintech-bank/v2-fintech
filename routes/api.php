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
        Route::get("/", [\App\Http\Controllers\Api\Core\ResellerController::class, 'list'])->name('api.reseller.list');
        Route::get("{reseller_id}", [\App\Http\Controllers\Api\Core\ResellerController::class, 'get']);
        Route::put("{reseller_id}", [\App\Http\Controllers\Api\Core\ResellerController::class, 'update']);
        Route::delete("{reseller_id}", [\App\Http\Controllers\Api\Core\ResellerController::class, 'delete']);

        Route::post("{reseller_id}/withdraw/{withdraw_id}/sendCode", [\App\Http\Controllers\Api\Core\ResellerController::class, 'sendCode']);
    });

    Route::prefix('category')->group(function () {
        Route::get("{category_id}", [\App\Http\Controllers\Api\Core\DocumentCategoryController::class, 'info']);
        Route::put("{category_id}", [\App\Http\Controllers\Api\Core\DocumentCategoryController::class, 'update']);
        Route::delete("{category_id}", [\App\Http\Controllers\Api\Core\DocumentCategoryController::class, 'delete']);
    });

    Route::prefix('epargne')->group(function () {
        Route::get("{plan_id}", [\App\Http\Controllers\Api\Core\PlanEpargneController::class, 'info']);
        Route::put("{plan_id}", [\App\Http\Controllers\Api\Core\PlanEpargneController::class, 'update']);
        Route::delete("{plan_id}", [\App\Http\Controllers\Api\Core\PlanEpargneController::class, 'delete']);
    });

    Route::prefix('pret')->group(function () {
        Route::get("{pret_id}", [\App\Http\Controllers\Api\Core\TypePretController::class, 'info']);
        Route::put("{pret_id}", [\App\Http\Controllers\Api\Core\TypePretController::class, 'update']);
        Route::delete("{pret_id}", [\App\Http\Controllers\Api\Core\TypePretController::class, 'delete']);
    });

    Route::prefix('forfait')->group(function () {
        Route::get("{forfait_id}", [\App\Http\Controllers\Api\Core\PackageController::class, 'info']);
        Route::put("{forfait_id}", [\App\Http\Controllers\Api\Core\PackageController::class, 'update']);
        Route::delete("{forfait_id}", [\App\Http\Controllers\Api\Core\PackageController::class, 'delete']);
    });

    Route::prefix('service')->group(function () {
        Route::get("{service_id}", [\App\Http\Controllers\Api\Core\ServiceController::class, 'info']);
        Route::put("{service_id}", [\App\Http\Controllers\Api\Core\ServiceController::class, 'update']);
        Route::delete("{service_id}", [\App\Http\Controllers\Api\Core\ServiceController::class, 'delete']);
    });

    Route::prefix('version')->group(function () {
        Route::get('/types', [\App\Http\Controllers\Api\Core\VersionController::class, 'getTypes']);
        Route::get("{version_id}", [\App\Http\Controllers\Api\Core\VersionController::class, 'info']);
        Route::put("{version_id}", [\App\Http\Controllers\Api\Core\VersionController::class, 'update']);
        Route::delete("{version_id}", [\App\Http\Controllers\Api\Core\VersionController::class, 'delete']);
    });

    Route::post('/document', [\App\Http\Controllers\Api\Core\DocumentController::class, 'upload']);

});

Route::prefix('user')->group(function () {
    Route::get("{user_id}/info", [\App\Http\Controllers\Api\User\UserController::class, 'info']);
});
