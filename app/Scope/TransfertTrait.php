<?php

namespace App\Scope;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Notifications\Customer\RejectedTransferNotification;
use App\Services\Fintech\Payment\Transfers;

trait TransfertTrait
{
    protected function immediatTransfer(CustomerTransfer $transfer): void
    {
        $api = new Transfers();
        $transaction = CustomerTransaction::find($transfer->transaction_id);

        if ($api->callTransfer($transfer) == 201) {
            if($transfer->amount <= $transfer->wallet->solde_remaining) {
                CustomerTransactionHelper::updated($transaction);

                $transfer->update([
                    'status' => $transfer->status == 'in_transit' ? 'paid' : 'in_transit'
                ]);
            } else {
                $this->failedTransfer($transfer, $transaction, "Solde Insuffisant");

                $this->createFraisBancaire("Virement Bancaire | REF: {$transfer->reference} | Motif: {$transfer->reason} | Montant: {$transfer->amount_format}");
            }
        } else {
            $this->failedTransfer($transfer, $transaction, "Retour banque distante invalide");
        }
    }

    protected function differedTransfer(CustomerTransfer $transfer)
    {
        $api = new Transfers();
        $transaction = CustomerTransaction::find($transfer->transaction_id);
    }

    protected function failedTransfer(CustomerTransfer $transfer, CustomerTransaction $transaction, string $raison)
    {
        CustomerTransactionHelper::deleteTransaction($transaction);
        $transfer->update([
            'status' => "failed"
        ]);
        $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, $raison, "Comptes & Moyens de paiement"));
    }
}
