<?php

namespace App\Services\Powens;

class Powens
{
    public function getClientAccessToken($auth_code)
    {
        return \Http::post('https://fintech-sandbox.biapi.pro/2.0/auth/token/access', [
            'code' => $auth_code,
            'client_id' => config('services.powens.client_id'),
            'client_secret' => config('services.powens.client_secret')
        ])->object();
    }
}
