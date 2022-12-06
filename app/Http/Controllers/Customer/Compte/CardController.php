<?php

namespace App\Http\Controllers\Customer\Compte;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;

class CardController extends Controller
{
    public function index($wallet_uuid)
    {
        $wallet = CustomerWallet::where('uuid', $wallet_uuid)->first();

        return view('customer.compte.card.index', [
            'customer' => Customer::find(auth()->user()->customers->id),
            "cards" => $wallet->cards
        ]);
    }
}
