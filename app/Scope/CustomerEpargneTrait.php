<?php

namespace App\Scope;

trait CustomerEpargneTrait
{
    public function calcProfit($profit_actuel, $capital, $percent_plan)
    {
        return $profit_actuel + ($capital * $percent_plan / 100);
    }
}
