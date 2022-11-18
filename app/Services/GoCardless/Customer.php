<?php

namespace App\Services\GoCardless;

class Customer extends Api
{
    public function lists()
    {
        return $this->client->customers()->list()->records;
    }
}
