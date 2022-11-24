<?php

namespace App\Console\Commands;

use App\Models\Customer\CustomerWallet;
use App\Services\SlackNotifier;
use Illuminate\Console\Command;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

class SystemEpargneCommand extends Command
{
    use LaravelSchedulerCustomMutex;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epargne {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        $this->setSignature('epargne {action}');
        parent::__construct();
        $this->slack = new SlackNotifier('#fintech-site');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->checkCustomMutex()) {
            return 0;
        }
        return match ($this->argument('action')) {
            "activeWallet" => $this->activeWallet(),
        };

    }

    private function activeWallet()
    {
        $wallets = CustomerWallet::where('type', 'epargne')->where('status', 'pending')->get();
        $i = 0;

        dd($wallets);

        foreach ($wallets as $wallet) {
            if ($wallet->customer->documents()->where('reference', $wallet->epargne->reference)->where('signed_by_client', 1)->count() != 0){
                $wallet->update(['status' => 'active']);
                $i++;
            }
        }

        $this->slack->send("Activation des comptes d'épargne", json_encode([strip_tags("Nombre de compte mise a jours: ").$i]));
    }
}
