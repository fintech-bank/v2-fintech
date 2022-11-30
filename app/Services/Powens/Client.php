<?php

namespace App\Services\Powens;

class Client extends Powens
{
    public function list()
    {
        return \Http::withToken($this->auth_token)->get($this->endpoint."users/me/connections/4/accounts")->object();
    }
}
