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
        Route::post('states', [\App\Http\Controllers\Api\Core\GeoController::class, 'states']);
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
    Route::get('/bank/status', function () {
        $bank = new \App\Services\BankFintech();
        return response()->json($bank->status());
    });

    Route::prefix('state')->group(function () {
        Route::get('wallet', [\App\Http\Controllers\Api\Core\StateController::class, 'wallet']);
    });



});

Route::prefix('connect')->group(function () {
    Route::get('/customer_verify', [\App\Http\Controllers\Api\Connect\ConnectController::class, 'verifyCustomer']);
    Route::get('/bank/{bank_id}', [\App\Http\Controllers\Api\Connect\ConnectController::class, 'infoBank']);
    Route::post('/siret', [\App\Http\Controllers\Api\Connect\ConnectController::class, 'verifySiret']);
});

Route::prefix('user')->group(function () {
    Route::get('list', [\App\Http\Controllers\Api\User\UserController::class, 'lists']);
    Route::get("{user_id}/info", [\App\Http\Controllers\Api\User\UserController::class, 'info']);
    Route::post('verify/customer', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'verify']);
    Route::post('verify/domicile', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'verify']);
    Route::post('verify/revenue', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'verify']);
    Route::post('signate', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'signateDocument']);
    Route::get('signate/verify', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'verifySign']);
});

Route::prefix('manager')->group(function () {
    Route::prefix('folders')->group(function () {
        Route::get("/", [\App\Http\Controllers\Api\Manager\FoldersController::class, 'lists']);
        Route::post("/", [\App\Http\Controllers\Api\Manager\FoldersController::class, 'store']);
        Route::delete("/{folder}", [\App\Http\Controllers\Api\Manager\FoldersController::class, 'delete'])->where(['folder' => '.*']);
    });

    Route::prefix('files')->group(function () {
        Route::get("/", [\App\Http\Controllers\Api\Manager\FilesController::class, 'lists']);
        Route::get("{reference_id}", [\App\Http\Controllers\Api\Manager\FilesController::class, 'getFile']);
        Route::post("/", [\App\Http\Controllers\Api\Manager\FilesController::class, 'store']);
        Route::delete("/{file}", [\App\Http\Controllers\Api\Manager\FilesController::class, 'delete'])->where(['file' => '.*']);
    });
});

Route::prefix('stat')->group(function () {
    Route::get('agentDashboard', [\App\Http\Controllers\Api\Stat\StatController::class, 'agentDashboard']);

});

Route::prefix('calendar')->group(function () {
    Route::post("list", [\App\Http\Controllers\Api\Calendar\CalendarController::class, 'list']);
});

Route::prefix('webhook')->group(function () {
    Route::post('personna', function (Request $request) {
        event(new \App\Events\Core\PersonnaWebbhookEvent($request->all()));
    });
});

Route::prefix('customer')->group(function () {
    Route::get('/search', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'search']);
    Route::post('verifSecure/{code}', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'verifSecure']);
    Route::get('{customer_id}/verifAllSolde', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'verifAllSolde']);
    Route::get('{customer_id}/endettement', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'endettement']);
    Route::post('{customer_id}/write-sms', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'writeSms']);
    Route::post('{customer_id}/write-mail', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'writeMail']);
    Route::put('{customer_id}/reinitPass', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'reinitPass']);
    Route::put('{customer_id}/reinitCode', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'reinitCode']);
    Route::put('{customer_id}/reinitAuth', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'reinitAuth']);
    Route::put('{customer_id}/business', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'updateBusiness']);
    Route::post('{customer_id}/alert', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'alert']);
    Route::post('{customer_id}/verify', [\App\Http\Controllers\Api\Customer\CustomerController::class, 'verify']);

    Route::prefix('{customer_id}/wallet')->group(function () {
        Route::get('{number_account}', [\App\Http\Controllers\Api\Customer\CustomerWalletController::class, 'info']);
        Route::get('{number_account}/chartSummary', [\App\Http\Controllers\Api\Customer\CustomerWalletController::class, 'chartSummary']);
        Route::post('{number_account}/request/overdraft', [\App\Http\Controllers\Api\Customer\CustomerWalletController::class, 'requestOverdraft']);
        Route::put('{number_account}', [\App\Http\Controllers\Api\Customer\CustomerWalletController::class, 'update']);
        Route::post('/', [\App\Http\Controllers\Agent\Customer\CustomerWalletController::class, 'store']);

        Route::prefix('{number_account}/transaction')->group(function () {
            Route::post('{transaction_uuid}', [\App\Http\Controllers\Api\Customer\TransactionController::class, 'update']);
        });

        Route::prefix('{number_account}/transfers')->group(function () {
            Route::post('/', [\App\Http\Controllers\Api\Customer\TransferController::class, 'store']);
            Route::get('{transfer_uuid}', [\App\Http\Controllers\Api\Customer\TransferController::class, 'info']);
            Route::put('{transfer_uuid}', [\App\Http\Controllers\Api\Customer\TransferController::class, 'update']);
        });

        Route::prefix('{number_account}/sepa')->group(function () {
            Route::get('{sepa_uuid}', [\App\Http\Controllers\Api\Customer\SepaController::class, 'info']);
            Route::put('{sepa_uuid}', [\App\Http\Controllers\Api\Customer\SepaController::class, 'update']);
        });

        Route::prefix('{number_account}/card')->group(function () {
            Route::post('/', [\App\Http\Controllers\Api\Customer\CreditCardController::class, 'store']);
            Route::put('{card_id}', [\App\Http\Controllers\Api\Customer\CreditCardController::class, 'update']);
        });

        Route::prefix('{number_account}/pret')->group(function () {
            Route::put('{pret_reference}', [\App\Http\Controllers\Api\Customer\PretController::class, 'update']);
        });
    });

    Route::prefix('{customer_id}/beneficiaire')->group(function () {
        Route::post('/', [\App\Http\Controllers\Api\Customer\BeneficiaireController::class, 'store']);
    });

    Route::prefix('{customer_id}/subscribe')->group(function () {
        Route::post('overdraft', [\App\Http\Controllers\Api\Customer\SubscribeController::class, 'overdraft']);
    });
    Route::prefix('{customer_id}/pret')->group(function () {
        Route::post('verify', [\App\Http\Controllers\Api\Customer\PretController::class, 'verify']);
        Route::delete('{reference}/caution/{id}', [\App\Http\Controllers\Api\Customer\PretController::class, 'deleteCaution']);
    });
});

Route::prefix('insurance')->group(function () {
    Route::post('/', [\App\Http\Controllers\Api\Insurance\InsuranceController::class, 'store']);

    Route::prefix('{reference}/claim')->group(function () {
        Route::post('/', [\App\Http\Controllers\Api\Insurance\ClaimController::class, 'store']);
    });
});

Route::prefix('loan')->group(function () {

});
