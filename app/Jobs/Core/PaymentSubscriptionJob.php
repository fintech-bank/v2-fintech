<?php

namespace App\Jobs\Core;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Customer $customer;
    public CustomerWallet $wallet;

    /**
     * Create a new job instance.
     *
     * @param Customer $customer
     * @param CustomerWallet $wallet
     */
    public function __construct(Customer $customer, CustomerWallet $wallet)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $package = $this->customer->package;
        CustomerTransactionHelper::create('debit',
            'souscription',
            'Cotisation Mensuelle ' . $package->name,
            $package->price,
            $this->wallet->id,
            true,
            'Cotisation Mensuelle ' . $package->name,
            now());
    }
}
