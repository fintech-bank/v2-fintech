<?php

namespace App\Jobs\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerSepa;
use App\Notifications\Customer\RefundSepaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class RefundSepaJob implements ShouldQueue
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
        $this->sepa->update([
            'status' => 'refunded'
        ]);

        CustomerTransactionHelper::create(
            'credit',
            'sepa',
            "Remboursement PRLV SEPA {$this->sepa->number_mandate} DE: {$this->sepa->creditor}",
            Str::replace('-', '', $this->sepa->amount),
            $this->sepa->wallet->id,
            true,
            "Remboursement PRLV SEPA {$this->sepa->number_mandate} DE: {$this->sepa->creditor}",
            now()
        );

        $this->sepa->wallet->customer->info->notify(new RefundSepaNotification($this->sepa->wallet->customer, $this->sepa));
    }
}
