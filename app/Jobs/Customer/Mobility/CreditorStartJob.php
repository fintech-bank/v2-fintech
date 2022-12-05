<?php

namespace App\Jobs\Customer\Mobility;

use App\Helper\CustomerSepaHelper;
use App\Models\Customer\CustomerMobility;
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

                CustomerSepaHelper::createPrlv(
                    $mvm->amount,
                    $this->mobility->wallet,
                    $mvm->creditor,
                    $mvm->date
                );
            }
            $this->mobility->update(['status' => "creditor_end"]);
        }
        $this->mobility->customer->info->notify(new UpdateMobilityNotification($this->mobility->customer, $this->mobility, 'Contact avec ma banque'));
        dispatch(new TerminatedJob($this->mobility))->delay($this->mobility->date_transfer);
    }
}
