<?php

namespace App\Scope;

use App\Helper\LogHelper;
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
        $error = collect();
        if(json_decode($epargne->plan->info_retrait)->amount < $request->get('amount')) {
            LogHelper::insertLogSystem('error', "Montant Supérieurs à la limite autorisée.");
            return false;
        }

        if($epargne->wallet->balance_actual < $request->get('amount')) {
            LogHelper::insertLogSystem('error', "Montant supérieurs au montant disponible sur le compte.");
            return false;
        }

        return true;
    }
}
