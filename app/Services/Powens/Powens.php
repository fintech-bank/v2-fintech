<?php

namespace App\Services\Powens;

class Powens
{
    public string $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://fintech-sandbox.biapi.pro/2.0/';
    }

    public function getClientAccessToken($auth_code)
    {
        return \Http::post($this->endpoint.'auth/token/access', [
            'code' => $auth_code,
            'client_id' => config('services.powens.client_id'),
            'client_secret' => config('services.powens.client_secret')
        ])->object();
    }
}
