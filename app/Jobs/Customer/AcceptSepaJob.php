<?php

namespace App\Jobs\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerSepa;
use App\Notifications\Customer\NewPrlvPresented;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AcceptSepaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CustomerSepa $sepa;

    /**
     * Create a new job instance.
     *
     * @param CustomerSepa $sepa
     */
    public function __construct(CustomerSepa $sepa)
    {
        //
        $this->sepa = $sepa;
        $this->onQueue('sepa');
    }

    public function tags()
    {
        return ['customer', 'sepa:'.$this->sepa->id];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transaction = CustomerTransactionHelper::create(
            'debit',
            'sepa',
            "Prélèvement SEPA ACC {$this->sepa->wallet->number_account} DE: {$this->sepa->creditors()->first()->name}",
            $this->sepa->amount,
            $this->sepa->wallet->id,
            true,
            "Prélèvement SEPA ACC {$this->sepa->wallet->number_account} DE: {$this->sepa->creditors()->first()->name} ID: {$this->sepa->creditors()->first()->identifiant} REF: {$this->sepa->uuid} MANDAT {$this->sepa->number_mandate}",
            now()
        );
        $this->sepa->update([
            'status' => 'processed',
            'transaction_id' => $transaction->id
        ]);

        $this->sepa->wallet->customer->info->notify(new NewPrlvPresented($this->sepa));
    }
}
