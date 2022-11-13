<?php

namespace App\Services\Fintech\Payment;

class Sepa
{
    public function acceptSepa()
    {
        return \Http::get('https://payment.fintech.ovh/sepa/accept')->object();
    }
}
