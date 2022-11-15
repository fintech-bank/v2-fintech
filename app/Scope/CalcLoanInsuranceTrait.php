<?php

namespace App\Scope;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use Illuminate\Support\Collection;

trait CalcLoanInsuranceTrait
{
    private static $taeg_category;

    /**
     * @param Customer $customer
     * @param CustomerPret $pret
     * @param string $taeg_category
     * @return Collection
     */
    public static function calcul(Customer $customer, CustomerPret $pret, string $taeg_category): \Illuminate\Support\Collection
    {
        self::$taeg_category = $taeg_category;
        return collect([
            'total' => self::calcAllInfo($customer, $pret),
            'mensuality' => self::calcAllInfo($customer, $pret) / $pret->duration,
            'category' => self::$taeg_category
        ]);
    }

    private static function calcAllInfo(Customer $customer, CustomerPret $pret)
    {
        return self::calcAmountForLoanAmount($pret) + self::calcAmountForCustomerAge($customer) + self::calcAmountForPro($customer);
    }

    private static function percentTaeg()
    {
        return match (self::$taeg_category) {
            "N" => 0,
            "D" => 1.6,
            "DIM" => 3.56,
            default => 4.36
        };
    }

    private static function calcAmountForLoanAmount(CustomerPret $pret)
    {
        return $pret->amount_loan * self::percentTaeg() / 100;
    }

    private static function calcAmountForCustomerAge(Customer $customer)
    {
        $age = $customer->info->datebirth->diffInYears(now());
        if($age <= 35) {
            return ($age * $age) * self::percentTaeg() / 100;
        } elseif ($age > 35 && $age <= 50) {
            return ($age * ($age * 1.3)) * self::percentTaeg() / 100;
        } else {
            return ($age * ($age * 1.6)) * self::percentTaeg() / 100;
        }
    }

    private static function calcAmountForPro(Customer $customer)
    {
        if($customer->situation->pro_category == 'Sans Emploie') {
            return self::calcAmountForCustomerAge($customer) * 1.5;
        } else {
            return self::calcAmountForCustomerAge($customer) * 1.1;
        }
    }
}
