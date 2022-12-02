<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\DocumentFile;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\SendLinkForContract;
use App\Notifications\Customer\SendLinkForContractNotification;
use App\Notifications\Customer\SendRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubscribeController extends ApiController
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

    public function cashback($customer_id, Request $request)
    {
        $customer = Customer::find($customer_id);
        $data = [
            'civility' => $customer->info->civility,
            'firstname' => $customer->info->firstname,
            'lastname' => $customer->info->lastname,
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'customer_id' => $customer_id
        ];

        $http = Http::withoutVerifying()->post('https://cashback.fintech.ovh/api/auth/register', $data)->body();

        dd($http);
    }
}
