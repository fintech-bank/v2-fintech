<?php

namespace App\Jobs\Customer;


use App\Models\Customer\Customer;
use App\Notifications\Customer\Alert\SameDefaultPasswordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AlertCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param Customer $customer
     * @param string $alert
     */
    public function __construct(public Customer $customer, public string $alert, public $delayed)
    {
        $this->delay($this->delayed);
    }

    public function handle()
    {
        dd($this->customer);
        match ($this->alert) {
            "password" => $this->customer->info->notify(new SameDefaultPasswordNotification($this->customer))
        };
    }
}
