<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
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
            "executeCalcProfitEpargne" => $this->executeCalcProfitEpargne(),
            "virProfitEpargne" => $this->virProfitEpargne()
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
                    if ($customer->documents()->where('reference', $epargne->reference)->where('signable', 1)->where('signed_by_client', 1)->count() != 0) {
                        $wallet->update(['status' => 'active']);
                        if ($epargne->plan->profit_days != 0)
                            $epargne->update([
                                'next_profit' => now()->addDays($epargne->plan->profit_days),
                                'unlocked_at' => now()->addDays($epargne->plan->unlocked_at)
                            ]);
                        $i++;
                    }
                }
            }
        }

        $this->slack->send("Activation des comptes d'épargne", json_encode([strip_tags("Nombre de compte mise a jours: ") . $i]));
    }

    private function executeCalcProfitEpargne()
    {
        $wallets = CustomerWallet::where('status', 'active')->where('type', 'epargne')->get();
        $i = 0;

        foreach ($wallets as $wallet) {
            if($wallet->epargne->next_prlv->startOfDay() == $wallet->epargne->next_prlv->startOfDay()) {
                $wallet->epargne->profit = $wallet->epargne->calcProfit($wallet->epargne->profit, $wallet->balance_actual, $wallet->epargne->plan->profit_percent);
                $wallet->epargne->save();
                $i++;
            }
        }

        $this->slack->send("Calcul des profits des comptes épargnes", json_encode([strip_tags("Nombre de compte mise à jours: ").$i]));
    }

    private function virProfitEpargne()
    {
        $wallets = CustomerWallet::where('status', 'active')->where('type', 'epargne')->get();
        $i = 0;

        foreach ($wallets as $wallet) {
            if($wallet->epargne->start->startOfDay() == $wallet->epargne->start->startOfDay()) {
                CustomerTransactionHelper::createCredit(
                    $wallet->id,
                    'virement',
                    'Intêret sur compte',
                    'Intêret courue sur la période du '.$wallet->epargne->start->format("d/m/Y")." au ".now()->format('d/m/Y'),
                    $wallet->epargne->profit,
                    true,
                    now()
                );

                $wallet->epargne->update([
                    'profit' => 0
                ]);

                $i++;
            }
        }

        $this->slack->send("Virement des intêret des comptes épargnes", json_encode([strip_tags("Nombre de compte mise a jours: ").$i]));
    }
}
