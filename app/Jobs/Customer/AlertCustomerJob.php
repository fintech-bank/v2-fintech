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

    public int $customer_id;
    public string $alert;
    public $delayed;

    /**
     * @param $customer_id
     * @param string $alert
     * @param $delayed
     */
    public function __construct($customer_id, string $alert, $delayed)
    {
        $this->customer_id = $customer_id;
        $this->alert = $alert;
        $this->delayed = $delayed;
        $this->delay($this->delayed);
        $this->onQueue('alert');
    }

    public function handle()
    {
        $customer = Customer::find($this->customer_id);
        match ($this->alert) {
            "password" => $customer->info->notify(new SameDefaultPasswordNotification($this->customer))
        };
    }
}
