<?php

namespace App\Jobs\Customer;

use App\Models\Customer\CustomerSepa;
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }
}
