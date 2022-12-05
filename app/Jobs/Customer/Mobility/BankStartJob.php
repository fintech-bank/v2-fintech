<?php

namespace App\Jobs\Customer\Mobility;

use App\Helper\CustomerSepaHelper;
use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerMobility;
use App\Models\Customer\CustomerMobilityMvm;
use App\Notifications\Customer\UpdateMobilityNotification;
use App\Services\BankFintech;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BankStartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public CustomerMobility $mobility)
    {
    }

    public function handle()
    {
        $bank = new BankFintech();
        $transfers = $bank->callTransferDoc();
        $this->mobility->update(['status' => "bank_start"]);

        if ($this->mobility->type->select_mvm) {
            foreach ($transfers->mvms as $transfer) {
                $this->mobility->mouvements()->create([
                    'uuid' => \Str::uuid(),
                    'type_mvm' => $transfer->type_mvm,
                    'reference' => $transfer->reference,
                    'creditor' => $transfer->creditor,
                    'amount' => $transfer->amount,
                    'customer_mobility_id' => $this->mobility->id,
                    'date_transfer' => $transfer->date_transfer,
                ]);
            }
            $this->mobility->update(['status' => "select_mvm_bank"]);
        } else {
            foreach ($transfers->mvms as $transfer) {
                $mvm = $this->mobility->mouvements()->create([
                    'uuid' => \Str::uuid(),
                    'type_mvm' => $transfer->type_mvm,
                    'reference' => $transfer->reference,
                    'creditor' => $transfer->creditor,
                    'amount' => $transfer->amount,
                    'customer_mobility_id' => $this->mobility->id,
                    'date_transfer' => $transfer->date_transfer,
                    'valid' => true,
                ]);

                match ($mvm->type_mvm) {
                    "virement" => $this->postVirement($mvm),
                    "prlv" => $this->postPrlv($mvm)
                };
            }

            if($this->mobility->cloture) {
                if($transfers->account->solde > 0) {
                    CustomerTransactionHelper::createCredit(
                        $this->mobility->wallet->id,
                        'virement',
                        'Virement Solde Transbank',
                        "Virement Compte {$transfers->account->number} vers {$this->mobility->wallet->number_account} | Transbank N°{$this->mobility->ref_mandate}",
                        $transfers->account->solde,
                        true,
                        now()
                    );
                }
            }

            $this->mobility->update(['status' => "bank_end"]);

            dispatch(new CreditorStartJob($this->mobility));
        }
        $this->mobility->customer->info->notify(new UpdateMobilityNotification($this->mobility->customer, $this->mobility, 'Contact avec ma banque'));
    }

    private function postVirement(CustomerMobilityMvm $mvm)
    {
        $rec_start = $mvm->mobility->date_transfer->addMonth();
        $mvm->mobility->wallet->transfers()->create([
            'uuid' => $mvm->uuid,
            "amount" => $mvm->amount,
            "reference" => $mvm->reference,
            "reason" => "Virement vers ".$mvm->creditor,
            "type_transfer" => 'courant',
            'type' => 'permanent',
            'recurring_start' => $rec_start,
            'recurring_end' => $rec_start->addYear(),
            'customer_wallet_id' => $mvm->mobility->wallet->id
        ]);
    }

    private function postPrlv(CustomerMobilityMvm $mvm)
    {
        CustomerSepaHelper::createPrlv(
            $mvm->amount,
            $mvm->mobility->wallet,
            $mvm->creditor,
            $mvm->date_transfer
        );

    }
}
