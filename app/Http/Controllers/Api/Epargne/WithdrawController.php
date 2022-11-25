<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerEpargne;
use App\Notifications\Customer\SendCodeSignApiNotification;
use Illuminate\Http\Request;

class WithdrawController extends ApiController
{
    public function store($reference, Request $request)
    {
        $epargne = CustomerEpargne::where('reference', $reference)->first();
        $code = random_numeric(6);

        if($epargne->wallet->solde_remaining < $request->get('amount')) {
            $withdraw = $epargne->wallet->withdraws->create([
                'reference' => generateReference(),
                'amount' => $request->get('amount'),
                'status' => 'terminated',
                'code' => base64_encode($code),
                'customer_wallet_id' => $epargne->wallet->id,
                'customer_withdraw_dab_id' => 1
            ]);

            $transaction = CustomerTransactionHelper::createDebit(
                $epargne->wallet->id,
                'retrait',
                \Str::upper("Retrait d'espèce en Agence"),
                \Str::upper("Retrait {$withdraw->reference} | {$withdraw->updated_at->format('d/m')} {$withdraw->updated_at->format('H:i')}"),
                $withdraw->amount,
                true,
                now()
            );

            $withdraw->update([
                'customer_transaction_id' => $transaction->id,
            ]);

            return $this->sendSuccess();
        } else {
            return $this->sendWarning("Solde insuffisant");
        }
    }
}
