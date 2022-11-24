<?php

namespace App\Scope;

use App\Models\Core\EpargnePlan;
use App\Models\Customer\CustomerEpargne;
use Illuminate\Http\Request;

trait CustomerEpargneTrait
{
    public function calcProfit($profit_actuel, $capital, $percent_plan)
    {
        return $profit_actuel + ($capital * $percent_plan / 100);
    }

    public static function verifyInfoTransfer(CustomerEpargne $epargne, Request $request)
    {
        if(json_decode($epargne->plan->info_retrait)->amount < $request->get('amount')) {
            return false;
        }

        if($epargne->wallet->balance_actual < $request->get('amount')) {
            return false;
        }

        return true;
    }
}
