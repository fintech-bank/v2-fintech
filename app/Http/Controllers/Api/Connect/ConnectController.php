<?php

namespace App\Http\Controllers\Api\Connect;

use App\Http\Controllers\Controller;
use App\Models\Core\Bank;
use App\Services\BankFintech;
use App\Services\Sirene;
use Illuminate\Http\Request;

class ConnectController extends Controller
{
    public function verifyCustomer(Request $request)
    {
        $bank = new BankFintech();
        $result = $bank->callInter();

        return response()->json($result);
    }

    public function infoBank($bank_id)
    {
        $bank = Bank::query()->find($bank_id);

        return response()->json($bank);
    }

    public function verifySiret(Request $request)
    {
        return Sirene::siret($request->get('siret'));
    }
}
