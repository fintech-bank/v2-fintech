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

        if (CustomerEpargneTrait::verifyInfoTransfer($epargne, $request)) {
            $transfer = CustomerTransfer::create([
                'uuid' => \Str::uuid(),
                'amount' => $request->get('amount'),
                'reference' => generateReference(),
                'reason' => 'Virement vers '.$epargne->payment->name_account_generic,
                'type' => $request->get('type'),
                'transfer_date' => $request->get('type') == 'immediat' || $request->get('type') == 'differed' ? $request->get('transfer_date') : null,
                'recurring_start' => $request->get('type') == 'permanent' ? $request->get('recurring_start') : null,
                'recurring_end' => $request->get('type') == 'permanent' ? $request->get('recurring_end') : null,
                'customer_wallet_id' => $request->get('customer_wallet_id'),
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
                'reason' => 'Virement vers '.$epargne->payment->name_account_generic,
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

    public function update($epargne_reference, $transfer_reference, Request $request)
    {
        $transfer = CustomerTransfer::where('reference', $transfer_reference)->first();

        return match ($request->get('action')) {
            "accept" => $this->acceptTransfer($transfer, $request),
            "refuse" => ""
        };
    }

    private function acceptTransfer(CustomerTransfer $transfer, Request $request)
    {
        if($transfer->amount > $transfer->wallet->balance_actual) {
            return $this->sendWarning("Le montant du transfers ne permet pas sont envoie");
        } else {
            $transfer->update([
                'status' => 'in_transit'
            ]);

            $transaction_ep = CustomerTransactionHelper::createDebit(
                $transfer->wallet->id,
                'virement',
                'Virement ' . $transfer->wallet->name_account_generic,
                'REFERENCE ' . $transfer->reference . ' | ' . $transfer->wallet->epargne->plan->name . ' ~ ' . $transfer->wallet->number_account,
                $transfer->amount,
            );

            CustomerTransactionHelper::createCredit(
                $transfer->wallet->epargne->payment->id,
                'virement',
                'Virement ' . $transfer->wallet->name_account_generic,
                'REFERENCE ' . $transfer->reference . ' | ' . $transfer->wallet->epargne->plan->name . ' ~ ' . $transfer->wallet->number_account,
                $transfer->amount,
            );

            $transfer->update([
                'transaction_id' => $transaction_ep->id
            ]);

            return $this->sendSuccess();
        }
    }
}