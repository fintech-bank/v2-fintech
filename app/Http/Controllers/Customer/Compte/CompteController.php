<?php

namespace App\Http\Controllers\Customer\Compte;

use App\Charts\Customer\WalletExpenseChart;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use App\Services\Cashback\CashbackApi;

class CompteController extends Controller
{
    public function index()
    {
        $cash = new CashbackApi();
        //dd($cash->callWallet(auth()->user()->customers->id)->data);
        return view('customer.compte.index', [
            "customer" => Customer::find(auth()->user()->customers->id),
            'wallets' => Customer::find(auth()->user()->customers->id)->wallets,
            'cashback' => isset($cash->callWallet(auth()->user()->customers->id)->data) ?? null
        ]);
    }

    public function wallet($wallet_uuid, WalletExpenseChart $chart)
    {
        $wallet = CustomerWallet::where('uuid', $wallet_uuid)->first();
        //dd($chart->build($wallet->id));
        return view('customer.compte.show', [
            'wallet' => $wallet,
            'chart' => $chart->build($wallet->id)
        ]);
    }
}
