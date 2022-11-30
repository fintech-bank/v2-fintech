<?php

namespace App\Services\Powens;

class Client extends Powens
{
    public function list()
    {
        return \Http::get($this->endpoint."users")->object();
    }
}
