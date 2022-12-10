<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use App\Notifications\Customer\OppositTransactionNotification;
use App\Notifications\Customer\RejectTransactionNotification;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    public function update($customer, $wallet, $transaction_uuid, Request $request)
    {
        $transaction = CustomerTransaction::where('uuid', $transaction_uuid)->first();

        switch ($request->get('action')) {
            case 'accept':
                $transaction->wallet->update([
                    'balance_coming' => $transaction->wallet->balance_coming - $transaction->amount
                ]);
                $transaction->wallet->update([
                    'balance_actual' => $transaction->wallet->balance_actual + $transaction->amount
                ]);

                $transaction->update([
                    'confirmed' => true,
                    'confirmed_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json($transaction);

            case 'reject':
                $transaction->wallet->update([
                    'balance_coming' => $transaction->wallet->balance_coming - $transaction->amount
                ]);

                $transaction->delete();
                $transaction->wallet->customer->info->notify(new RejectTransactionNotification($transaction->wallet->customer, $transaction, $request->get('raison'), "Comptes & Moyens de paiement"));

                return response()->json();

            case 'opposit':
                $transaction->opposit()->create([
                    'raison_opposit' => $request->get('raison'),
                    'customer_transaction_id' => $transaction->id
                ]);
                $transaction->wallet->update([
                    'balance_coming' => $transaction->wallet->balance_coming - $transaction->amount
                ]);

                $transaction->wallet->customer->info->notify(new OppositTransactionNotification($transaction->wallet->customer, $transaction, $request->get('raison'), "Comptes & Moyens de paiement"));
                return response()->json();

            case 'remb':
                CustomerTransactionHelper::create(
                    'credit',
                    'autre',
                    "Remboursement bancaire",
                    \Str::replace('-', '', $transaction->amount),
                    $transaction->wallet->id,
                    true,
                    $transaction->designation,
                    now(),
                );

                return response()->json();
        }


    }

    public function info($customer_id, $number_account, $transaction_uuid)
    {
        $transaction = CustomerTransaction::where('uuid', $transaction_uuid)->first();

        return $this->sendSuccess(null, [$transaction]);
    }
}
