<?php

namespace App\Scope;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;

trait CalcLoanTrait
{
    use CalcLoanInsuranceTrait;
    public static function getLoanInterest($amount_loan, $interest_percent)
    {
        return $amount_loan * $interest_percent / 100;
    }

    public static function calcRestantDu($loan, $euro = true)
    {
        if ($euro == true) {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');
            $calc = $loan->amount_du - $prlv_effect;

            return eur($calc);
        } else {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');

            return $loan->amount_du - $prlv_effect;
        }
    }

    public static function calcMensuality(Customer $customer, CustomerPret $pret, $assurance = 'D')
    {
        $ass = self::calcul($customer, $pret, $assurance);

        $subtotal = $pret->amount_loan + $ass['total'];
        $subInterest = self::getLoanInterest($pret->amount_loan, $pret->plan->tarif->type_taux == 'fixe' ? $pret->plan->tarif->interest : self::calcLoanIntestVariableTaxe($pret));
        $int_mensuality = $subInterest / $duration;

        return ($subtotal / $duration) + $int_mensuality;
    }

    public static function calcLoanIntestVariableTaxe(CustomerPret $pret)
    {
        $min = $pret->plan->tarif->min_interest;
        $max = $pret->plan->tarif->max_interest;

        if($pret->amount_loan <= 100) {
            return $min;
        } elseif($pret->amount_loan > 101 && $pret->amount_loan <= 500) {
            return min($min * 1.3, $max);
        } elseif($pret->amount_loan > 501 && $pret->amount_loan <= 3000) {
            return min($min * 2.6, $max);
        } elseif($pret->amount_loan > 3001 && $pret->amount_loan <= 5000) {
            return min($min * 3.1, $max);
        } else {
            return min($min * 3.3, $max);
        }
    }
}
