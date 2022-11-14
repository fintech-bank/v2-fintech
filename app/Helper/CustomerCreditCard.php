<?php

namespace App\Helper;

use App\Notifications\Customer\NewCreditCardNotificationNotification;
use App\Notifications\Customer\SendCreditCardCodeNotification;
use Plansky\CreditCard\Generator;

class CustomerCreditCard
{
    public static function calcLimitPayment($amount): float
    {
        $calc = round($amount * 1.9, -2);

        return $calc;
    }

    public static function calcLimitRetrait($amount): float
    {
        $calc = round($amount / 1.9, -2);

        return $calc;
    }

    public static function createCard($customer, $wallet, $type = 'physique', $support = 'classic', $debit = 'immediate', $limit_payment = 0)
    {
        $card_generator = new Generator();
        if ($type == 'physique') {
            $card = $wallet->cards()->create([
                'exp_month' => now()->month,
                'number' => $card_generator->single('40', 16),
                'type' => $type,
                'support' => $support,
                'debit' => $debit,
                'cvc' => rand(100, 999),
                'code' => base64_encode(rand(1000, 9999)),
                'limit_retrait' => self::calcLimitRetrait($customer->income->pro_incoming),
                'limit_payment' => self::calcLimitPayment($customer->income->pro_incoming),
                'customer_wallet_id' => $wallet->id,
            ]);

            // Génération des contrats
            DocumentFile::createDoc(
                $customer,
                'Convention CB Physique',
                null,
                3,
                null,
                true,
                true,
                false,
                true,
                ['card' => $card]
            );

            // Notification Code Carte Bleu
            $customer->info->notify(new SendCreditCardCodeNotification($customer, base64_decode($card->code), $card));
            $customer->info->notify(new NewCreditCardNotificationNotification($customer, $card));

        } else {
            $card = $wallet->cards()->create([
                'exp_month' => now()->month,
                'number' => $card_generator->single('41', 16),
                'type' => $type,
                'support' => $support,
                'debit' => $debit,
                'cvc' => rand(100, 999),
                'code' => base64_encode(rand(1000, 9999)),
                'limit_retrait' => 0,
                'limit_payment' => $limit_payment,
                'customer_wallet_id' => $wallet->id,
            ]);
        }

        return $card;
    }

}
