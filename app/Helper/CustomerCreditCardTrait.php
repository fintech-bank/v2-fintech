<?php

namespace App\Helper;

trait CustomerCreditCardTrait
{

    /**
     * @return bool
     */
    public function isDiffered(): bool
    {
        return $this->debit == 'differed' ? true : false;
    }

    public function isContact()
    {
        return $this->payment_contact ? true : false;
    }

    public function getType()
    {
        return \Str::ucfirst($this->type);
    }

    public function getStatus($format = '')
    {
        if($format == 'color') {
            return match ($this->status) {
                "active" => "success",
                "inactive" => "secondary",
                "canceled" => "danger",
            };
        } elseif ($format == 'text') {
            return match ($this->status) {
                "active" => "Carte Active",
                "inactive" => "Carte Inactive",
                "canceled" => "Carte Annulé",
            };
        } else {
            return match ($this->status) {
                "active" => "check",
                "inactive" => "ban",
                "canceled" => "xmark-circle",
            };
        }
    }

    public function calcLimitPayment($amount): float
    {
        return round($amount * 1.9, -2);
    }

    public function restantDiffered()
    {
        return $this->differed_limit - $this->transactions()
                ->isDiffered()
                ->whereBetween('differed_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('amount');
    }

    public function usedDiffered($percent = false)
    {
        $calc = $this->transactions()
            ->isDiffered()
            ->whereBetween('differed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        if(!$percent) {
            return $calc;
        } else {
            if($calc != 0) {
                return $this->restantDiffered() * 100 / $this->differed_limit;
            } else {
                return 0;
            }
        }
    }

    public  function getTransactionsMonthWithdraw($percent = false)
    {
        if ($percent == false) {
            return - $this->transactions()
                ->where('type', 'retrait')
                ->where('confirmed', true)
                ->where('customer_credit_card_id', $this->id)
                ->whereBetween('confirmed_at', [now()->subDays(7), now()])
                ->get()
                ->sum('amount');
        } else {
            $tran = - $this->transactions()
                ->where('type', 'retrait')
                ->where('confirmed', true)
                ->where('customer_credit_card_id', $this->id)
                ->whereBetween('confirmed_at', [now()->subDays(7), now()])
                ->get()
                ->sum('amount');

            return $tran * 100 / $this->limit_retrait;
        }
    }
}
