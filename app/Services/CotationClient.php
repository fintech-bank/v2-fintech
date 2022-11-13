<?php

namespace App\Services;

use App\Models\Customer\Customer;

class CotationClient
{
    public function calc(Customer $customer)
    {
        $score = 0;
        $score += $this->soldeAccounts($customer);
        $score += $this->alertPret($customer);
        $score += $this->banquefrance($customer);
        $score += $this->alertDebitAccount($customer);
        $score += $this->nbAlertDebitAccount($customer);
        $score += 23;

        return intval($score / 10);
    }

    private function soldeAccounts(Customer $customer)
    {
        $sum = $customer->wallets()
            ->where('type', '!=', 'pret')
            ->where('status', 'active')
            ->sum('balance_actual');

        if($sum > 0){
            return 12;
        } else {
            return -12;
        }
    }

    private function alertPret(Customer $customer)
    {
        $sum = $customer->prets()
            ->where('alert', true)
            ->count();

        if ($sum == 0) {
            return 10;
        } else {
            return -10;
        }
    }

    private function banquefrance(Customer $customer)
    {
        $i = 0;
        if($customer->ficp)
            $i++;
        if($customer->fcc)
            $i++;

        if($i == 0) {
            return 5;
        } elseif ($i == 1) {
            return 0;
        } else {
            return -5;
        }
    }

    private function alertDebitAccount(Customer $customer)
    {
        $c = $customer->wallets()
            ->where('alert_debit', true)
            ->count();

        if($c == 0) {
            return 25;
        } else {
            return -25;
        }
    }
    private function nbAlertDebitAccount(Customer $customer)
    {
        $c = $customer->wallets()
            ->sum('nb_alert');

        if($c == 0) {
            return 25;
        } else {
            return -25;
        }
    }
}
