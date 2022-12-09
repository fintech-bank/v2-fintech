<?php

namespace App\Services\Plaid;

use TomorrowIdeas\Plaid\Plaid;

class Api
{
    public Plaid $client;

    public function __construct()
    {
        $this->client = new Plaid(config('services.plaid.client_id'), config('services.plaid.secret_key'), config('services.plaid.environment'));
    }

}
