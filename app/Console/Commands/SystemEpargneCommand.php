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
                if ($wallet->status == 'pending') {
                    if($customer->documents()->where('reference', $epargne->reference)->where('signable', 1)->where('signed_by_client', 1)->count() != 0) {
                        $wallet->update(['status' => 'active']);
                        if($epargne->plan->profit_days != 0)
                            $epargne->update(['next_profit' => now()->addDays($epargne->plan->profit_days)]);
                        $i++;
                    }
                }
            }
        }

        $this->slack->send("Activation des comptes d'épargne", json_encode([strip_tags("Nombre de compte mise a jours: ").$i]));
    }
}
