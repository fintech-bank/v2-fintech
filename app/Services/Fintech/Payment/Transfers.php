<?php

namespace App\Services\Fintech\Payment;

use App\Models\Customer\CustomerTransfer;

class Transfers
{
    /**
     * @param CustomerTransfer $transfer
     * @return int
     */
    public function callTransfer(CustomerTransfer $transfer): int
    {
        return \Http::get('https://payment.fintech.ovh/api/transfer/call', [
            'uuid' => $transfer->uuid,
            'amount' => $transfer->amount,
            'beneficiaire' => $transfer->beneficiaire
        ])->status();
    }
}
