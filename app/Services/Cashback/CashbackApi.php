<?php

namespace App\Services\Cashback;

class CashbackApi
{
    private string $endpoint = "https://cashback.fintech.ovh/api";

    public function callWallet($customer_id)
    {
        return \Http::post($this->endpoint.'/wallet', ["customer_id" => $customer_id])->object();
    }
}
