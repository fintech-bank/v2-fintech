<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Helper\CustomerWalletHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function store(Request $request, $customer_id)
    {
        dd($request->all());
        $customer = Customer::find($customer_id);
        try {
            switch ($request->get('action')) {
                case 'wallet':
                    $wallet = CustomerWalletHelper::createWallet(
                        $customer,
                        'compte',
                        0,
                        0,
                        0,
                        0,
                        'active'
                    );
                    return response()->json($wallet);
                case 'epargne':
                    $wallet = CustomerWalletHelper::createWallet(
                        $customer,
                        'epargne',
                        0, 0, 0, 0, 'active'
                    );
            }
        } catch (\Exception $exception) {

        }
    }
}
