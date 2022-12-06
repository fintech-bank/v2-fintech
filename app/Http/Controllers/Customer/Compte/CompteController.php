<?php

namespace App\Http\Controllers\Customer\Compte;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Services\Cashback\CashbackApi;

class CompteController extends Controller
{
    public function index()
    {
        $cash = new CashbackApi();
        return view('customer.compte.index', [
            "customer" => Customer::find(auth()->user()->customers->id),
            'wallets' => Customer::find(auth()->user()->customers->id)->wallets,
            'cashback' => $cash->callWallet(auth()->user()->customers->id)->data
        ]);
    }
}
