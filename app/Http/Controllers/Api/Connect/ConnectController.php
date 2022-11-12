<?php

namespace App\Http\Controllers\Api\Connect;

use App\Http\Controllers\Controller;
use App\Services\BankFintech;
use Illuminate\Http\Request;

class ConnectController extends Controller
{
    public function verifyCustomer(Request $request)
    {
        $bank = new BankFintech();
        $result = $bank->callInter();

        return response()->json($result);
    }

    public function infoBank(Request $request)
    {
        dd($request->all());
    }
}
