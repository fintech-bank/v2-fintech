<?php

namespace App\Services\Fintech\Payment;

use App\Models\Customer\CustomerTransfer;

class Transfers
{
    public function callTransfer(CustomerTransfer $transfer)
    {
        return \Http::get('https://payment.fintech.ovh/api/transfer/call', [
            'uuid' => $transfer->uuid,
            'amount' => $transfer->amount,
            'beneficiaire' => $transfer->beneficiaire
        ])->status();
    }
}
