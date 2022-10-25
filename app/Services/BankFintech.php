<?php

namespace App\Services;

use App\Models\Core\Agency;
use App\Models\Customer\Customer;

class BankFintech
{
    public function callRefundSepa($sepa)
    {
        return \Http::get('http://bank.fintech.ovh/refund_request?bank_id=' . $sepa)->object();
    }

    public function callStatusBank($bank_name)
    {
        return \Http::get('http://bank.fintech.ovh/status_request?bank_name=' . $bank_name)->object();
    }

    public function callInter()
    {
        return \Http::get('http://bank.fintech.ovh/inter')->object();
    }

    public function callTransferDoc(Customer $customer, Agency $agence, string $num_mandate)
    {
        return \Http::timeout(50)->post('http://bank.fintech.ovh/mobility/transfer_doc', [
            "customer" => $customer,
            "agence" => $agence,
            "num_mandate" => $num_mandate
        ])->object();
    }

    public function status()
    {
        return \Http::get('http://bank.fintech.ovh/status')->object();
    }
}
