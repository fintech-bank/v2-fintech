<?php

namespace App\Helper;

use App\Models\Customer\CustomerFacelia;

class CustomerFaceliaHelper
{
    public static function calcComptantMensuality($wallet)
    {
        return $wallet->transactions()->where('type', 'facelia')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
    }

    public static function calcOpsSepaMensuality($wallet)
    {
        return $wallet->transactions()->where('type', 'sepa')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
    }

    public static function calcMensuality($comptant, $sepa)
    {
        return $comptant + $sepa;
    }

    public static function verifCompatibility($customer, $card)
    {
        $score = 0;

        // Verif Coefficient
        $coef = $customer->cotation;
        if ($coef <= 6) {
            $score--;
        } else {
            $score++;
        }

        // Verifie si FICP
        if ($customer->ficp == 1) {
            $score--;
        } else {
            $score++;
        }

        if ($card->support == 'premium' || $card->support == 'infinite') {
            $score++;
        } else {
            $score--;
        }

        return $score;
    }

    public static function create($wallet, $customer, $amount, $card)
    {
        $pret = self::createFaceliaPret($wallet, $customer, $amount, $card);

        return self::createFacelia($pret->wallet, $pret, $card, $wallet);
    }

    private static function createFaceliaPret($wallet, $customer, $amount, $card)
    {
        return CustomerLoanHelper::createLoan(
            $wallet,
            $customer,
            $amount,
            6,
            36,
            20,
            'accepted',
            $card
        );
    }

    private static function createFacelia($wallet, $pret, $card, $payment)
    {
        return CustomerFacelia::create([
            'reference' => generateReference(),
            'amount_available' => $pret->amount_loan,
            'wallet_payment_id' => $payment->id,
            'customer_pret_id' => $pret->id,
            'customer_credit_card_id' => $card->id,
            'customer_wallet_id' => $wallet->id,
        ]);
    }
}
