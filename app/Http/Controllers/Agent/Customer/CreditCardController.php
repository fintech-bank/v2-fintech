<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCreditCard;

class CreditCardController extends Controller
{
    public function index($customer_id, $number_account, $card_id)
    {
        $card = CustomerCreditCard::find($card_id);

        dd($card);
    }
}
