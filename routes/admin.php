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

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.dashboard');

    Route::prefix('erp')->group(function () {
        Route::prefix('agence')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\Erp\AgenceController::class, 'index'])->name('admin.erp.agence.index');
            Route::post("/", [\App\Http\Controllers\Admin\Erp\AgenceController::class, 'store'])->name('admin.erp.agence.store');
            Route::get("{agency_id}/edit", [\App\Http\Controllers\Admin\Erp\AgenceController::class, 'edit'])->name('admin.erp.agence.edit');
        });

        Route::prefix('bank')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\Erp\Bank\BankController::class, 'index'])->name('admin.erp.bank.index');
        });

        Route::prefix('reseller')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\Erp\ResellerController::class, 'index'])->name('admin.erp.reseller.index');
            Route::post("/", [\App\Http\Controllers\Admin\Erp\ResellerController::class, 'store'])->name('admin.erp.reseller.store');
            Route::get("{reseller_id}", [\App\Http\Controllers\Admin\Erp\ResellerController::class, 'show'])->name('admin.erp.reseller.show');
            Route::put("{reseller_id}", [\App\Http\Controllers\Admin\Erp\ResellerController::class, 'update'])->name('admin.erp.reseller.update');
            Route::get("{reseller_id}/edit", [\App\Http\Controllers\Admin\Erp\ResellerController::class, 'edit'])->name('admin.erp.reseller.edit');
        });
    });

    Route::prefix('configuration')->group(function () {
        Route::prefix('category')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\Configuration\CategoryController::class, 'index'])->name('admin.config.category.index');
            Route::post("/", [\App\Http\Controllers\Admin\Configuration\CategoryController::class, 'store'])->name('admin.config.category.store');
        });

        Route::prefix('epargne')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\Configuration\PlanEpargneController::class, 'index'])->name('admin.config.epargne.index');
            Route::post("/", [\App\Http\Controllers\Admin\Configuration\PlanEpargneController::class, 'store'])->name('admin.config.epargne.store');
        });

        Route::prefix('pret')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\Configuration\TypePretController::class, 'index'])->name('admin.config.pret.index');
            Route::post("/", [\App\Http\Controllers\Admin\Configuration\TypePretController::class, 'store'])->name('admin.config.pret.store');
        });

        Route::prefix('forfait')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\Configuration\PackageController::class, 'index'])->name('admin.config.package.index');
            Route::post("/", [\App\Http\Controllers\Admin\Configuration\PackageController::class, 'store'])->name('admin.config.package.store');
        });
    });

    Route::prefix('system')->group(function () {
        Route::prefix('log-banque')->group(function () {
            Route::get("/", [\App\Http\Controllers\Admin\System\LogBanqueController::class, 'index'])->name('admin.system.log.index');
        });
    });
});
