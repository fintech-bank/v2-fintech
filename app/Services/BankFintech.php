<?php

namespace App\Services;

use App\Models\Core\Agency;
use App\Models\Customer\Customer;

class BankFintech
{
    public function callRefundSepa($sepa)
    {
        return \Http::get('https://bank.fintech.ovh/refund_request?bank_id=' . $sepa)->object();
    }

    public function callStatusBank($bank_name)
    {
        return \Http::get('https://bank.fintech.ovh/status_request?bank_name=' . $bank_name)->object();
    }

    public function callInter()
    {
        return \Http::get('https://bank.fintech.ovh/inter')->object();
    }

    public function callTransferDoc()
    {
        return \Http::timeout(50)->post('https://bank.fintech.ovh/mobility/transfer_doc')->object();
    }

    public function callCreditorDoc()
    {
        return \Http::timeout(50)->post('https://bank.fintech.ovh/mobility/creditor_doc')->object();
    }

    public function status()
    {
        return \Http::get('https://bank.fintech.ovh/status')->status();
    }
}
