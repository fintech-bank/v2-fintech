<?php

namespace App\Console\Commands;

use App\Models\Core\LogBanque;
use App\Models\Reseller\Reseller;
use Illuminate\Console\Command;

class SystemAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:admin {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande Administrateur';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'deleteLog':
                $this->DeleteLogBank();
                break;

            case 'shipTpe':
                $this->ShipTpe();
                break;
        }

        return Command::SUCCESS;
    }

    private function DeleteLogBank() {
        $logs = LogBanque::all();
        $bar = $this->output->createProgressBar(count($logs));
        $bar->start();
        foreach ($logs as $log) {
            $log->delete();
            $bar->advance();
        }
        $bar->finish();
        $this->info("Suppression des logs bancaires: ".count($logs));
    }

    private function ShipTpe()
    {
        $resellers = Reseller::all();
        $i = 0;

        foreach ($resellers as $reseller) {
            foreach ($reseller->shippings as $shipping) {
                if($shipping->updated_at->addDays(1)->startOfDay() == now()->startOfDay()) {
                    $shipping->tracks()->create([
                        'state' => 'prepared',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                } elseif ($shipping->updated_at->addDays(1)->startOfDay() == now()->startOfDay()) {
                    $shipping->tracks()->create([
                        'state' => 'in_transit',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                } elseif ($shipping->updated_at->addDays(2)->startOfDay() == now()->startOfDay()) {
                    $shipping->tracks()->create([
                        'state' => 'delivered',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                } else {
                    $shipping->tracks()->create([
                        'state' => 'ordered',
                        'shipping_id' => $shipping->id
                    ]);
                    $i++;
                }
            }
        }

        $this->info("Nombre de tracker mis à jours: $i");
    }
}
