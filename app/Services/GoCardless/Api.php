<?php

namespace App\Services\GoCardless;

use GoCardlessPro\Client;
use GoCardlessPro\Environment;

class Api
{
    private string $environment;
    private mixed $accessToken;
    public Client $client;

    public function __construct()
    {
        $this->environment = config('app.env') == 'local' ? Environment::SANDBOX : Environment::LIVE;
        $this->accessToken = config('services.gocardless.access_token');
        $this->client = new Client([
            'access_token' => $this->accessToken,
            'environment' => $this->environment
        ]);

    }
}
