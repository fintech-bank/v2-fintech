<?php

namespace App\Console\Commands;

use App\Models\Customer\Customer;
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
        match ($this->argument('action')) {
            "activeWallet" => $this->activeWallet(),
        };

        return Command::SUCCESS;
    }

    private function activeWallet()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();
        $i = 0;

        foreach ($customers as $customer) {
            foreach ($customer->epargnes()->get() as $epargne) {
                $wallet = $epargne->wallet;
                dd($wallet);
            }
        }


        $this->slack->send("Activation des comptes d'épargne", json_encode([strip_tags("Nombre de compte mise a jours: ").$i]));
    }
}
