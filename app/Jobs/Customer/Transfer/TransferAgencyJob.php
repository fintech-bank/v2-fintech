<?php

namespace App\Jobs\Customer\Transfer;

use App\Models\Core\Agency;
use App\Models\Customer\CustomerTransferAgency;
use App\Notifications\Customer\UpdateTransferAgencyNotification;
use Faker\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferAgencyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private CustomerTransferAgency $transferAgency)
    {
    }

    public function handle()
    {
        $faker = Factory::create('fr_FR');

        $this->transferAgency->update(['status' => 'progress']);

        if($faker->boolean()) {
            $agent = $this->transferAgency->agency->agents->random();
            $agency = $this->transferAgency->customer->update(['agency_id' => $this->transferAgency->agency_id, "agent_id" => $agent->id]);

            $this->transferAgency->update(['status' => 'terminated']);

            $this->transferAgency->customer->info->notify(new UpdateTransferAgencyNotification($this->transferAgency->customer, $this->transferAgency, "Contact avec votre banque"));
        }
    }
}
