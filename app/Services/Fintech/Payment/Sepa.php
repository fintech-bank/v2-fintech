<?php

namespace App\Services\Fintech\Payment;

class Sepa
{
    public function acceptSepa()
    {
        return \Http::get('https://payment.fintech.ovh/api/sepa/accept')->object();
    }

    public function rembSepaRequest(\App\Models\Customer\CustomerSepa $sepa)
    {
        return \Http::post('https://payment.fintech.ovh/api/sepa/remb', ["ics" => $sepa->creditors()->first()->identifiant])->object();
    }

    public function generateICS()
    {
        return \Http::get('https://payment.fintech.ovh/api/sepa/new_ics')->body();
    }
}
