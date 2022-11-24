<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerTransfer;
use App\Scope\CustomerEpargneTrait;
use Illuminate\Http\Request;

class TransferController extends ApiController
{
    public function store($reference, Request $request)
    {
        $epargne = CustomerEpargne::where('reference', $reference)->first();

        return match ($request->get('type_wallet')) {
            "epargne" => $this->transferEpargne($epargne, $request),
        };
    }

    private function transferEpargne(CustomerEpargne $epargne, Request $request)
    {
        if (CustomerEpargneTrait::verifyInfoTransfer($epargne, $request)) {
            $transfer = CustomerTransfer::create([
                'uuid' => \Str::uuid(),
                'amount' => $request->get('amount'),
                'reference' => generateReference(),
                'reason' => null,
                'type' => $request->get('type'),
                'transfer_date' => $request->get('type') == 'immediat' || $request->get('type') == 'differed' ? $request->get('transfer_date') : null,
                'recurring_start' => $request->get('type') == 'permanent' ? $request->get('recurring_start') : null,
                'recurring_end' => $request->get('type') == 'permanent' ? $request->get('recurring_end') : null,
                'customer_wallet_id' => $request->get('customer_wallet_id'),
                'customer_beneficiaire_id' => $request->get('customer_beneficiaire_id'),
                'status' => 'in_transit'
            ]);

            $transaction_ep = CustomerTransactionHelper::createDebit(
                $epargne->wallet->id,
                'virement',
                'Virement ' . $epargne->wallet->name_account_generic,
                'REFERENCE ' . $transfer->reference . ' | ' . $epargne->plan->name . ' ~ ' . $epargne->wallet->number_account,
                $transfer->amount,
            );

            CustomerTransactionHelper::createCredit(
                $epargne->payment->id,
                'virement',
                'Virement ' . $epargne->wallet->name_account_generic,
                'REFERENCE ' . $transfer->reference . ' | ' . $epargne->plan->name . ' ~ ' . $epargne->wallet->number_account,
                $transfer->amount,
            );

            $transfer->update([
                'transaction_id' => $transaction_ep->id
            ]);

            return $this->sendSuccess(null, [$transfer]);
        } else {
            $transfer = CustomerTransfer::create([
                'uuid' => \Str::uuid(),
                'amount' => $request->get('amount'),
                'reference' => generateReference(),
                'reason' => null,
                'type' => $request->get('type'),
                'transfer_date' => $request->get('type') == 'immediat' || $request->get('type') == 'differed' ? $request->get('transfer_date') : null,
                'recurring_start' => $request->get('type') == 'permanent' ? $request->get('recurring_start') : null,
                'recurring_end' => $request->get('type') == 'permanent' ? $request->get('recurring_end') : null,
                'customer_wallet_id' => $request->get('customer_wallet_id'),
                'customer_beneficiaire_id' => $request->get('customer_beneficiaire_id'),
                'status' => 'pending'
            ]);

            return $this->sendWarning("Certaines vérification sont invalide mais le virement à été enregistré", [$transfer]);
        }
    }
}
