<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function info($customer_id, $number_account)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        return response()->json($wallet);
    }
}
