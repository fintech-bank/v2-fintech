<?php

namespace App\Scope;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerWallet;
use Faker\Factory;
use Illuminate\Support\Str;

trait TransactionTrait
{
    public function generateDepot($wallet_id)
    {
        return CustomerTransactionHelper::create(
            'credit',
            'depot',
            'Dépot sur votre compte | Ref: ' . Str::upper(Str::random(8)).' | '.now()->format('H:i'),
            ceil(rand(100,900)),
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
            'Retrait sur votre compte | Ref: ' . Str::upper(Str::random(8)).' | '.now()->format('H:i'),
            -ceil(rand(100,900)),
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
            if($card->debit == 'differed') {
                for ($i = 0; $i <= rand(0,2); $i++) {
                    $date = now();
                    $company = Str::limit($faker->company, 90, '');
                    $facelia = $faker->boolean(rand(0,50));

                    if($card->facelia) {
                        CustomerTransactionHelper::create(
                            $facelia ? 'facelia' : 'debit',
                            'payment',
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)).' | '.now()->format('H:i'),
                            -rand(0,999).".".rand(0,99),
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
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)).' | '.now()->format('H:i'),
                            -rand(0,999).".".rand(0,99),
                            $card->wallet->id,
                            true,
                            "Carte {$card->number_format} {$date->format('d/m')} {$company}",
                            $date,
                            $date,
                            $card->id,
                            $faker->boolean(rand(0,100)),
                        );
                    }

                }
            } else {
                for ($i = 0; $i <= rand(0,2); $i++) {
                    $date = now();
                    $company = Str::limit($faker->company, 90, '');
                    $facelia = $faker->boolean(rand(0,50));

                    if($card->facelia) {
                        CustomerTransactionHelper::create(
                            $facelia ? 'facelia' : 'debit',
                            'payment',
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)).' | '.now()->format('H:i'),
                            -rand(0,999).".".rand(0,99),
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
                            'Paiement par Carte Bancaire | Ref: ' . Str::upper(Str::random(8)).' | '.now()->format('H:i'),
                            -rand(0,999).".".rand(0,99),
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
}
