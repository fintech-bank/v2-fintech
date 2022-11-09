<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\UpdateStatusWalletNotification;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function info($customer_id, $number_account)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        return response()->json($wallet);
    }

    public function update($customer_id, $number_account, Request $request)
    {
        switch ($request->get('action')) {
            case 'state':
                $this->updateStateWallet($number_account, $request);
        }
    }

    public function requestOverdraft($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $result = $wallet->requestOverdraftPart();
        return response()->json($result);
    }

    private function updateStateWallet($number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $wallet->update([
            'status' => $request->get('status')
        ]);

        $wallet->customer->info->notify(new UpdateStatusWalletNotification($wallet->customer, $wallet, $wallet->status));
    }
}
