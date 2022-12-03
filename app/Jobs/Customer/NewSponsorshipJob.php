<?php

namespace App\Jobs\Customer;

use App\Models\Core\Sponsorship;
use App\Notifications\Customer\NewSponsorshipNotification;
use App\Notifications\Other\NewSponsorshipFilleulNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewSponsorshipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Sponsorship $sponsorship)
    {
    }

    public function handle()
    {
        $this->sponsorship->customer->info->notify(new NewSponsorshipNotification($this->sponsorship->customer, $this->sponsorship, "Avantage"));
        $this->sponsorship->notify(new NewSponsorshipFilleulNotification($this->sponsorship));
    }
}
