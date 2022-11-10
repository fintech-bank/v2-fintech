<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
                break;

            case 'opposit':
                $transaction->opposit()->create([
                    'raison_opposit' => $request->get('raison'),
                    'customer_transaction_id' => $transaction->id
                ]);



        }
    }
}
