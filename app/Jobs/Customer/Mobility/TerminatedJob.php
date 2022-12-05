<?php

namespace App\Jobs\Customer\Mobility;

use App\Models\Customer\CustomerMobility;
use App\Notifications\Customer\UpdateMobilityNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TerminatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public CustomerMobility $mobility)
    {
    }

    public function handle()
    {
        $this->mobility->update(['status' => "terminated"]);
        $this->mobility->customer->info->notify(new UpdateMobilityNotification($this->mobility->customer, $this->mobility, 'Contact avec ma banque'));
    }
}
