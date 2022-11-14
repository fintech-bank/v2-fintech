<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerCreditCard;
use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function store($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $card = CustomerCreditCard::createCard(
            $wallet->customer,
            $wallet,
            $request->get('type'),
            $request->get('support'),
            $request->get('debit'),
        );

        if($wallet->Numberofphysicalbankcardsexceeded()) {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Cotisation Carte Bancaire Physique',
                25,
                $wallet->id,
                true,
                'Carte Bancaire Supplémentaire N°'.$card->number_card_oscure,
                now(),
            );
        }

        if($wallet->Numberofvirtualbankcardsexceeded()) {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Cotisation Carte Bancaire Virtuel',
                10,
                $wallet->id,
                true,
                'Carte Bancaire virtuel Supplémentaire N°'.$card->number_card_oscure,
                now(),
            );
        }

        return response()->json();
    }
}
