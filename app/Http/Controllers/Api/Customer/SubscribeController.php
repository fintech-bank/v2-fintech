<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\DocumentFile;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function overdraft($customer_id, Request $request)
    {
        $wallet = CustomerWallet::find($request->get('wallet_id'));

        $wallet->update([
            'decouvert' => true,
            'balance_decouvert' => $request->get('balance_decouvert') == 0 ? $request->get('balance_max') : $request->get('balance_decouvert')
        ]);

        $doc = DocumentFile::createDoc(
            $wallet->customer,
            'autorisation_decouvert_permanent',
            'Autorisation Decouvert Permanente',
            3,
            generateReference(),
            true,
            true,
            false,
            true,
            ['wallet' => $wallet]
        );

        $wallet->customer->info->notify(new );
    }
}
