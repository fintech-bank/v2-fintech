<?php

namespace App\Helper;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerWallet;
use App\Scope\VerifCompatibilityBeforeLoanTrait;

class CustomerFaceliaHelper
{
    use VerifCompatibilityBeforeLoanTrait;
    public static function calcComptantMensuality(CustomerWallet $wallet)
    {
        return $wallet->transactions()->where('type', 'facelia')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
    }

    public static function calcOpsSepaMensuality(CustomerWallet $wallet)
    {
        return $wallet->transactions()->where('type', 'sepa')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
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
