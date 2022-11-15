<?php

namespace App\Scope;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;

trait VerifCompatibilityBeforeLoanTrait
{
    public static function verify(Customer $customer, $isRevolving = false, CustomerCreditCard $card = null): bool
    {
        $score = 0; // En pourcentage

        self::verifDebitAllWalletAccount($customer) < self::verifCreditAllWalletAccount($customer) ? $score += 100 : $score -= 100;
        self::verifFICP($customer) ? $score += 100 : $score -= 100;
        self::verifCotation($customer) ? $score += 100 : $score -= 100;
        self::verifAllSoldeWalletAccount($customer) ? $score += 100 : $score -= 100;
        self::verifAllSoldeEpargneAccount($customer) ? $score += 100 : $score -= 100;
        self::verifNbAlertOfAllWalletAccount($customer) ? $score += 100 : $score -= 100;
        self::verifNbLoan($customer) ? $score += 100 : $score -= 100;

        $calc = $score * 7 / 100;

        if($isRevolving) {
            self::creditCardIsNotClassicCard($card) ? $score += 100 : $score -= 100;
            $calc = $score * 8 / 100;
        }

        return $calc >= 25;
    }

    private static function verifDebitAllWalletAccount(Customer $customer): mixed
    {
        $sum = 0;
        foreach ($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet) {
            $sum += $wallet->transactions()->where('amount', '<=', 0)->sum('amount');
        }

        return $sum;
    }

    private static function verifCreditAllWalletAccount(Customer $customer): string
    {
        $sum = 0;
        foreach ($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet) {
            $sum += $wallet->transactions()->where('amount', '>=', 0)->sum('amount');
        }

        return \Str::replace('-', '', $sum);
    }

    private static function verifAllSoldeWalletAccount(Customer $customer): bool
    {
        $balance = $customer->wallets()->where('type', 'compte')->where('status', 'active')->sum('balance_actual');
        $decouvert = $customer->wallets()->where('type', 'compte')->where('status', 'active')->sum('balance_decouvert');

        return $balance + $decouvert >= 0;
    }

    private static function verifAllSoldeEpargneAccount(Customer $customer): bool
    {
        $balance = $customer->wallets()->where('type', 'epargne')->where('status', 'active')->sum('balance_actual');

        return $balance  >= 0;
    }

    private static function verifNbAlertOfAllWalletAccount(Customer $customer):bool
    {
        $alert = $customer->wallets()->where('type', 'compte')->where('status', 'active')->sum('nb_alert');

        return $alert == 0;
    }

    private static function verifNbLoan(Customer $customer)
    {
        $loans = $customer->wallets()->where('type', 'pret')->where('status', 'active')->count();

        return $loans <= 2;
    }

    private static function verifFICP(Customer $customer)
    {
        return $customer->ficp == 1;
    }

    private static function verifCotation(Customer $customer)
    {
        return $customer->cotation >= 6;
    }

    private static function creditCardIsNotClassicCard(CustomerCreditCard $card): bool
    {
        if($card->wallet->customer->info->type == 'part') {
            return $card->support->slug != 'visa-classic';
        } else {
            return true;
        }
    }
}
