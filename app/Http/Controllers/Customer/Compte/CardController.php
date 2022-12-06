<?php

namespace App\Http\Controllers\Customer\Compte;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerWallet;

class CardController extends Controller
{
    public function index()
    {
        return view('customer.compte.card.index', [
            'customer' => Customer::find(auth()->user()->customers->id),
            "wallets" => Customer::find(auth()->user()->customers->id)->wallets
        ]);
    }

    public function show($card_id)
    {
        $card = CustomerCreditCard::find($card_id);
        return view('customer.compte.card.index', [
            'customer' => Customer::find(auth()->user()->customers->id),
            "card" => $card,
            "wallet" => $card->wallet
        ]);
    }
}
