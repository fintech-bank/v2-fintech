<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\DocumentFile;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\SendLinkForContract;
use App\Notifications\Customer\SendLinkForContractNotification;
use App\Notifications\Customer\SendRequestNotification;
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
            'wallet.autorisation_decouvert_permanent',
            'Autorisation Decouvert Permanente',
            3,
            generateReference(),
            true,
            true,
            false,
            true,
            ['wallet' => $wallet]
        );

        $req = $wallet->customer->requests()->create([
            'reference' => $doc->reference,
            'sujet' => "Signature d'un document",
            'commentaire' => "Veuillez signez le document suivant: {$doc->name}",
            "link_model" => CustomerWallet::class,
            "link_id" => $wallet->id,
            "customer_id" => $wallet->customer->id
        ]);

        $wallet->customer->info->notify(new SendRequestNotification($wallet->customer, $req, "Comptes & Moyens de paiement"));

        return response()->json();
    }
}
