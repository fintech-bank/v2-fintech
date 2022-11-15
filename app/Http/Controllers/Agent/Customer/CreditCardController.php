<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCreditCard;

class CreditCardController extends Controller
{
    public function index($number_account, $card_id)
    {
        $card = CustomerCreditCard::find($card_id);

        return view('agent.customer.wallet.card.show', compact('card'));
    }
}
