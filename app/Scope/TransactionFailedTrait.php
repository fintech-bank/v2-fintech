<?php

namespace App\Scope;

use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Notifications\Customer\RejectedTransferNotification;
use App\Notifications\Customer\RejectSepaNotification;
use App\Notifications\Customer\RejectTransactionNotification;

trait TransactionFailedTrait
{
    protected function failedVirement(CustomerTransaction $transaction,string $raison)
    {
        $virement = CustomerTransfer::where('transaction_id', $transaction->id)->first();

        $virement->update([
            'status' => 'failed'
        ]);

        $transaction->createFraisBancaire("Rejet Virement | REF: {$virement->reference} - {$virement->reason}");
        $transaction->delete();

        $transaction->wallet->customer->info->notify(new RejectedTransferNotification($transaction->wallet->customer, $virement, $raison, "Comptes & Moyens de paiement"));

        return $transaction;
    }

    protected function failedPayment(CustomerTransaction $transaction, string $raison)
    {
        $transaction->wallet->customer->info->notify(new RejectTransactionNotification($transaction->wallet->customer, $transaction, $raison,"Comptes & Moyens de paiement"));
        $transaction->delete();
        return null;
    }

    protected function failedSepa(CustomerTransaction $transaction)
    {
        $sepa = CustomerSepa::where('transaction_id', $transaction->id)->first();

        $sepa->update(['status' => 'rejected']);
        $transaction->createFraisBancaire("Rejet Prélèvement | REF: {$sepa->number_mandate} | Beneficiaire: {$sepa->creditor} | Montant: {$this->amount_format}");
        $transaction->delete();

        $transaction->wallet->customer->info->notify(new RejectSepaNotification($transaction->wallet->customer, $sepa, 'Comptes et Moyens de paiement'));

        return $transaction;
    }
}
