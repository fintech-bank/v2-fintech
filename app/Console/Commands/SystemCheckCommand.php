<?php

namespace App\Console\Commands;

use App\Models\Customer\CustomerCheck;
use App\Notifications\Customer\UpdateCheckoutCheckNotification;
use App\Services\SlackNotifier;
use Illuminate\Console\Command;

class SystemCheckCommand extends Command
{
    protected $signature = 'check {action}';

    protected $description = 'Command description';
    private SlackNotifier $slack;

    public function __construct()
    {
        parent::__construct();
        $this->slack = new SlackNotifier('#fintech-site');
    }

    public function handle()
    {
        match ($this->argument('action')) {
            "setManufactureCheck" => $this->setManufactureCheck(),
            "setShipCheck" => $this->setShipCheck(),
            "setAvailableCheck" => $this->setAvailableCheck(),
        };

        return Command::SUCCESS;
    }

    private function setManufactureCheck()
    {
        $checks = CustomerCheck::where('status', 'checkout')->get();
        $i = 0;

        foreach ($checks as $check) {
            if($check->updated_at->startOfDay() == now()->startOfDay()) {
                $check->update(['status' => 'manufacture', 'updated_at' => now()]);

                $check->wallet->customer->info->notify(new UpdateCheckoutCheckNotification($check->wallet->customer, $check));
                $i++;
            }
        }

        $this->slack->send("Passage des commandes de chéquier en construction", json_encode([strip_tags("Nombre de chéquier mise a jours: ").$i]));
    }

    private function setShipCheck()
    {
        $checks = CustomerCheck::where('status', 'manufacture')->get();
        $i = 0;

        foreach ($checks as $check) {
            if($check->updated_at->addDay()->startOfDay() == now()->startOfDay()) {
                $check->update(['status' => 'ship', 'updated_at' => now()]);

                $check->wallet->customer->info->notify(new UpdateCheckoutCheckNotification($check->wallet->customer, $check));
            }
        }

        $this->slack->send("Passage des envoies de chéquier", json_encode([strip_tags("Nombre de chéquier mise a jours: ").$i]));
    }

    private function setAvailableCheck()
    {
        $checks = CustomerCheck::where('status', 'ship')->get();
        $i = 0;

        foreach ($checks as $check) {
            if($check->updated_at->addDays(2)->startOfDay() == now()->startOfDay()) {
                $check->update(['status' => 'outstanding', 'updated_at' => now()]);

                $check->wallet->customer->info->notify(new UpdateCheckoutCheckNotification($check->wallet->customer, $check));
            }
        }

        $this->slack->send("Chéquier mise en agence", json_encode([strip_tags("Nombre de chéquier mise a jours: ").$i]));
    }
}
