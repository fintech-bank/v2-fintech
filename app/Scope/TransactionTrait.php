<?php

namespace App\Scope;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait TransactionTrait
{
    use TransactionFailedTrait;
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
    public function createDebit(int $wallet_id, string $type_mvm, string $designation, string $description, float $amount, bool $confirmed = false, Carbon $confirmed_at = null, bool $differed = false, Carbon $differed_at = null, int $card_id = null): \Illuminate\Database\Eloquent\Model|CustomerTransaction
    {
        $amount = -$amount;
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
    public function createCredit(int $wallet_id, string $type_mvm, string $designation, string $description, float $amount, bool $confirmed = false, Carbon $confirmed_at = null, bool $differed = false, Carbon $differed_at = null, int $card_id = null): \Illuminate\Database\Eloquent\Model|CustomerTransaction
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

    public function generateDepot($wallet_id)
    {
        return CustomerTransactionHelper::create(
            'credit',
            'depot',
            'Dépot sur votre compte | Ref: ' . Str::upper(Str::random(8)) . ' | ' . now()->format('H:i'),
            ceil(rand(100, 900)),
            $wallet_id,
            true,
            "Dépot d'espèce sur votre compte",
            now(),
        );
    }

    public function generateRetrait($wallet_id)
    {
        return CustomerTransactionHelper::create(
            'debit',
            'Retrait',
            'Retrait sur votre compte | Ref: ' . Str::upper(Str::random(8)) . ' | ' . now()->format('H:i'),
            -ceil(rand(100, 900)),
            $wallet_id,
            true,
            "Retrait d'espèce sur votre compte",
            now(),
        );
    }

    public function generatePayment(CustomerWallet $wallet)
    {
        $faker = Factory::create('fr_FR');
        $cards = $wallet->cards()->where('status', 'active')->get();
        foreach ($cards as $card) {
            if ($card->debit == 'differed') {
                for ($i = 0; $i <= rand(0, 2); $i++) {
                    $date = now();
                    $company = Str::limit($faker->company, 90, '');
                    $facelia = $faker->boolean(rand(0, 50));

                    if ($card->facelia) {
                        CustomerTransactionHelper::create(
                            $facelia ? 'facelia' : 'debit',
                            'payment',
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)) . ' | ' . now()->format('H:i'),
                            -rand(0, 999) . "." . rand(0, 99),
                            $card->wallet->id,
                            $facelia ? $date->endOfMonth() : true,
                            "Carte {$card->number_format} {$date->format('d/m')} {$company}",
                            $facelia ? $date->endOfMonth() : $date,
                            $facelia ? $date->endOfMonth() : $date,
                            $card->id,
                        );
                    } else {
                        CustomerTransactionHelper::create(
                            'debit',
                            'payment',
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)) . ' | ' . now()->format('H:i'),
                            -rand(0, 999) . "." . rand(0, 99),
                            $card->wallet->id,
                            true,
                            "Carte {$card->number_format} {$date->format('d/m')} {$company}",
                            $date,
                            $date,
                            $card->id,
                            $faker->boolean(rand(0, 100)),
                        );
                    }

                }
            } else {
                for ($i = 0; $i <= rand(0, 2); $i++) {
                    $date = now();
                    $company = Str::limit($faker->company, 90, '');
                    $facelia = $faker->boolean(rand(0, 50));

                    if ($card->facelia) {
                        CustomerTransactionHelper::create(
                            $facelia ? 'facelia' : 'debit',
                            'payment',
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)) . ' | ' . now()->format('H:i'),
                            -rand(0, 999) . "." . rand(0, 99),
                            $card->wallet->id,
                            $facelia ? $date->endOfMonth() : true,
                            "Carte {$card->number_format} {$date->format('d/m')} {$company}",
                            $facelia ? $date->endOfMonth() : $date,
                            $facelia ? $date->endOfMonth() : $date,
                            $card->id,
                        );
                    } else {
                        CustomerTransactionHelper::create(
                            'debit',
                            'payment',
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)) . ' | ' . now()->format('H:i'),
                            -rand(0, 999) . "." . rand(0, 99),
                            $card->wallet->id,
                            true,
                            "Carte {$card->number_format} {$date->format('d/m')} {$company}",
                            $date,
                            $date,
                            $card->id,
                        );
                    }

                }
            }
        }
    }

    public function createFraisBancaire($description)
    {
        return $this->createDebit(
            $this->wallet->id,
            'frais',
            "Commission d'intervention",
            $description,
            2.5,
            'true',
            now()->startOfDay()
        );
    }

    public function verifAccountBalanceForTransaction(CustomerTransaction $transaction): bool
    {
        if ($transaction->amount <= $transaction->wallet->solde_remaining) {
            return true;
        } else {
            return false;
        }
    }

    protected function comingToConfirmedTransaction(CustomerTransaction $transaction): bool
    {
        return $transaction->update([
            "confirmed" => true,
            "confirmed_at" => now()->startOfDay(),
            "updated_at" => now()
        ]);
    }

    protected function comingFailed(CustomerTransaction $transaction): CustomerTransaction|null
    {
        return match ($transaction->type) {
            "virement" => $this->failedVirement($transaction),
            "payment" => $this->failedPayment($transaction),
            "sepa" => $this->failedSepa($transaction),
        };
    }

}
