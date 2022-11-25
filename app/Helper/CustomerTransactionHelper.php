<?php

namespace App\Helper;

use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerTransactionHelper
{
    public static function getTypeTransaction($type, $labeled = false, $symbol = false)
    {
        if ($symbol == true) {
            switch ($type) {
                case 'depot':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Dépot">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/depot.png)"></div>
                            </div>';
                    break;

                case 'retrait':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Retrait">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/retrait.png)"></div>
                            </div>';
                    break;

                case 'payment':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Paiement">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/payment.png)"></div>
                            </div>';
                    break;

                case 'virement':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Virement Bancaire">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/virement.png)"></div>
                            </div>';
                    break;

                case 'sepa':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Prélèvement">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/sepas.png)"></div>
                            </div>';
                    break;

                case 'frais':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Frais Bancaire">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/frais.png)"></div>
                            </div>';
                    break;

                case 'souscription':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Souscription">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/souscription.png)"></div>
                            </div>';
                    break;

                case 'facelia':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Crédit Facelia">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/payment.png)"></div>
                            </div>';
                    break;

                default:
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Autre">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/autre.png)"></div>
                            </div>';
                    break;
            }
        } elseif ($labeled == true) {
            return '<span class="badge badge-'.random_color().'"></span>';
        } else {
            return \Str::ucfirst($type);
        }
    }

    /**
     * @param int $wallet_id
     * @param string $type_mvm
     * @param string $designation
     * @param string $description
     * @param float $amount
     * @param bool $confirmed
     * @param Carbon|null $confirmed_at
     * @param bool $differed
     * @param Carbon|null $differed_at
     * @param int|null $card_id
     * @return Model|CustomerTransaction
     */
    public static function createDebit(
        int $wallet_id,
        string $type_mvm,
        string $designation,
        string $description,
        float $amount, bool
        $confirmed = false,
        Carbon $confirmed_at = null,
        bool $differed = false,
        Carbon $differed_at = null,
        Carbon $updated_at = null,
        int $card_id = null): \Illuminate\Database\Eloquent\Model|CustomerTransaction
    {
        $amount = $amount;
        $wallet = CustomerWallet::find($wallet_id);

        $transaction = CustomerTransaction::create([
            'uuid' => Str::uuid(),
            'type' => $type_mvm,
            'designation' => $designation,
            'description' => $description,
            'amount' => -$amount,
            'confirmed' => $confirmed ?? false,
            'confirmed_at' => $confirmed ? $confirmed_at : null,
            'differed' => $differed ?? false,
            'differed_at' => $differed ? $differed_at : null,
            'updated_at' => $updated_at != null ? $updated_at : now(),
            'customer_wallet_id' => $wallet_id,
            'customer_credit_card_id' => $card_id
        ]);

        if ($confirmed) {
            $wallet->update([
                'balance_actual' => $wallet->balance_actual - $amount,
            ]);
        } else {
            $wallet->update([
                'balance_coming' => $wallet->balance_coming - $amount
            ]);
        }

        return $transaction;
    }

    /**
     * @param int $wallet_id
     * @param string $type_mvm
     * @param string $designation
     * @param string $description
     * @param float $amount
     * @param bool $confirmed
     * @param Carbon|null $confirmed_at
     * @param bool $differed
     * @param Carbon|null $differed_at
     * @param int|null $card_id
     * @return Model|CustomerTransaction
     */
    public static function createCredit(int $wallet_id, string $type_mvm, string $designation, string $description, float $amount, bool $confirmed = false, Carbon $confirmed_at = null, bool $differed = false, Carbon $differed_at = null, int $card_id = null): \Illuminate\Database\Eloquent\Model|CustomerTransaction
    {
        $wallet = CustomerWallet::find($wallet_id);

        $transaction = CustomerTransaction::create([
            'uuid' => Str::uuid(),
            'type' => $type_mvm,
            'designation' => $designation,
            'description' => $description,
            'amount' => $amount,
            'confirmed' => $confirmed ?? false,
            'confirmed_at' => $confirmed ? $confirmed_at : null,
            'differed' => $differed ?? false,
            'differed_at' => $differed ? $differed_at : null,
            'customer_wallet_id' => $wallet_id,
            'customer_credit_card_id' => $card_id
        ]);

        if ($confirmed) {
            $wallet->update([
                'balance_actual' => $wallet->balance_actual + $amount,
            ]);
        } else {
            $wallet->update([
                'balance_coming' => $wallet->balance_coming + $amount
            ]);
        }

        return $transaction;
    }

    public static function create($type, $type_transaction, $description, $amount, $wallet_id, $confirm = true, $designation = null, $confirmed_at = null, $updated_at = null, $card_id = null, $differed = false)
    {
        if ($type == 'debit') {
            CustomerTransaction::create([
                'uuid' => \Str::uuid(),
                'type' => $type_transaction,
                'designation' => $designation == null ? $description : $designation,
                'description' => $description == null ? $designation : $description,
                'amount' => 0.00 - (float) $amount,
                'confirmed' => $confirm,
                'confirmed_at' => $confirmed_at,
                'customer_wallet_id' => $wallet_id,
                'updated_at' => $updated_at ?? now(),
                'customer_credit_card_id' => $card_id != null ? $card_id : null,
                'differed' => $differed ? 1 : 0,
                'differed_at' => $differed ? now()->endOfMonth() : null,
            ]);
            $transaction = CustomerTransaction::with('wallet')->latest()->first();

            $wallet = CustomerWallet::find($wallet_id);
            if ($confirm == true) {
                $wallet->balance_actual += $transaction->amount;
                $wallet->save();
            } else {
                $wallet->balance_coming += $amount;
                $wallet->save();
            }
        } else {
            CustomerTransaction::create([
                'uuid' => \Str::uuid(),
                'type' => $type_transaction,
                'designation' => $designation == null ? $description : $designation,
                'description' => $description == null ? $designation : $description,
                'amount' => $amount,
                'confirmed' => $confirm,
                'confirmed_at' => $confirmed_at,
                'customer_wallet_id' => $wallet_id,
                'updated_at' => $updated_at ?? now(),
            ]);
            $transaction = CustomerTransaction::with('wallet')->latest()->first();

            $wallet = CustomerWallet::find($wallet_id);
            if ($confirm == true) {
                $wallet->balance_actual += $transaction->amount;
                $wallet->save();
            } else {
                $wallet->balance_coming += $amount;
                $wallet->save();
            }
        }

        return $transaction;
    }

    public static function updated($transaction)
    {
        $transaction->wallet->update([
            'balance_actual' => $transaction->wallet->balance_actual + $transaction->amount,
            'balance_coming' => $transaction->wallet->balance_coming + $transaction->amount,
        ]);

        $transaction->update([
            'confirmed' => true,
            'confirmed_at' => now(),
            'updated_at' => now()
        ]);
    }

    public static function deleteTransaction($transaction)
    {
        if ($transaction->confirmed == 0) {
            $transaction->wallet->update([
                'balance_coming' => $transaction->wallet->balance_coming - $transaction->amount,
            ]);
        } else {
            $transaction->wallet->update([
                'balance_actual' => $transaction->wallet->balance_actual - $transaction->amount,
            ]);
        }

        $transaction->delete();
    }
}
