<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function store($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

    }
}
