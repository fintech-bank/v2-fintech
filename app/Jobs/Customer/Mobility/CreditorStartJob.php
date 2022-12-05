<?php

namespace App\Jobs\Customer\Mobility;

use App\Helper\CustomerSepaHelper;
use App\Helper\CustomerTransferHelper;
use App\Models\Customer\CustomerMobility;
use App\Models\Customer\CustomerTransfer;
use App\Notifications\Customer\UpdateMobilityNotification;
use App\Services\BankFintech;
use Carbon\Carbon;
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
            foreach ($creditors->creditors as $creditor) {
                $this->mobility->creditors()->create([
                    'uuid' => \Str::uuid(),
                    'creditor' => $creditor->creditor,
                    'reference' => $creditor->mandate_prlv,
                    'amount' => $creditor->creditor == 'SECU' || $creditor->creditor == 'CAF' ? $creditor->amount : -$creditor->amount,
                    'date' => Carbon::create(now()->year, now()->addMonth()->month, $creditor->days),
                    'valid' => false,
                    'customer_mobility_id' => $this->mobility->id,
                ]);
            }
            $this->mobility->update(['status' => "select_mvm_creditor"]);
        } else {
            foreach ($creditors->creditors as $creditor) {
                $mvm = $this->mobility->creditors()->create([
                    'uuid' => \Str::uuid(),
                    'creditor' => $creditor->creditor,
                    'reference' => $creditor->mandate_prlv,
                    'amount' => $creditor->creditor == 'SECU' || $creditor->creditor == 'CAF' ? $creditor->amount : -$creditor->amount,
                    'date' => Carbon::create(now()->year, now()->addMonth()->month, $creditor->days),
                    'valid' => true,
                    'customer_mobility_id' => $this->mobility->id,
                ]);

                if($mvm->creditor == 'SECU' || $mvm->creditor == 'CAF') {
                    for ($i=1; $i <= 12; $i++) {
                        CustomerTransfer::create([
                            'uuid' => \Str::uuid(),
                            'amount' => $mvm->amount,
                            'reference' => $mvm->reference,
                            'reason' => "Virement {$mvm->creditor}",
                            'type_transfer' => 'courant',
                            'transfer_date' => Carbon::create(now()->year, now()->addMonths($i)->month, $creditor->days),
                            'customer_wallet_id' => $this->mobility->wallet->id,
                        ]);
                    }
                } else {
                    CustomerSepaHelper::createPrlv(
                        $mvm->amount,
                        $this->mobility->wallet,
                        $mvm->creditor,
                        $mvm->date
                    );
                }
            }
            $this->mobility->update(['status' => "creditor_end"]);
        }
        $this->mobility->customer->info->notify(new UpdateMobilityNotification($this->mobility->customer, $this->mobility, 'Contact avec ma banque'));
        dispatch(new TerminatedJob($this->mobility))->delay($this->mobility->date_transfer);
    }
}
