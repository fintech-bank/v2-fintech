<?php

namespace App\Scope;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;

trait CalcLoanTrait
{
    use CalcLoanInsuranceTrait;
    public static function getLoanInterest($amount_loan, $interest_percent): float|int
    {
        return $amount_loan * $interest_percent / 100;
    }

    public static function calcRestantDu($loan, $euro = true): mixed
    {
        if ($euro) {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');
            $calc = $loan->amount_du - $prlv_effect;

            return eur($calc);
        } else {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');

            return $loan->amount_du - $prlv_effect;
        }
    }

    public static function calcMensuality(Customer $customer, CustomerPret $pret, $assurance = 'D'): float|int
    {
        $ass = self::calcul($customer, $pret, $assurance);

        $subtotal = $pret->amount_loan + $ass['total'];
        $subInterest = self::getLoanInterest($pret->amount_loan, $pret->plan->tarif->type_taux == 'fixe' ? $pret->plan->tarif->interest : self::calcLoanIntestVariableTaxe($pret));
        $int_mensuality = $subInterest / $pret->duration;

        return ($subtotal / $pret->duration) + $int_mensuality;
    }

    public static function calcLoanIntestVariableTaxe(CustomerPret $pret): float
    {
        $min = $pret->plan->tarif->min_interest;
        $max = $pret->plan->tarif->max_interest;

        if($pret->amount_loan <= 100) {
            return $min;
        } elseif($pret->amount_loan > 101 && $pret->amount_loan <= 500) {
            return $min/1.3;
        } elseif($pret->amount_loan > 501 && $pret->amount_loan <= 3000) {
            return $min/2.6;
        } elseif($pret->amount_loan > 3001 && $pret->amount_loan <= 5000) {
            return ceil($min/3.1);
        } else {
            return $max;
        }
    }

    public static function getPeriodicMensualityFromVitess($vitesse = 'low'): int
    {
        return match ($vitesse) {
            'low' => 36,
            'middle' => 24,
            default => 12,
        };
    }

    public static function calcAmountPaid(CustomerPret $pret)
    {
        return eur($pret->wallet->transactions()->where('confirmed', true)->sum('amount'));
    }
}
