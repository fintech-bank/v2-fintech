<?php

namespace App\Services\Powens;

class Client extends Powens
{
    public function list()
    {
        return \Http::withToken($this->auth_token)->get($this->endpoint."users/me/subscriptions")->object();
    }

    public function getConnector($id)
    {
        return \Http::withToken($this->auth_token)->get($this->endpoint."/users")->object();
    }
}
