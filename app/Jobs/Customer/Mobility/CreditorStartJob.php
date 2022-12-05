<?php

namespace App\Jobs\Customer\Mobility;

use App\Models\Customer\CustomerMobility;
use App\Services\BankFintech;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreditorStartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public CustomerMobility $mobility)
    {
    }

    public function handle()
    {
        $bank = new BankFintech();
        $creditors = $bank->callCreditorDoc();
        $this->mobility->update(['status' => 'creditor_start']);

        if($this->mobility->type->select_mvm) {

        }
    }
}
