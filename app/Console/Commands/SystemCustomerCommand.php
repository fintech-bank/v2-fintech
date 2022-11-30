<?php

namespace App\Console\Commands;

use App\Models\Customer\Customer;
use App\Notifications\Customer\UpdateStatusAccountNotification;
use App\Notifications\Customer\UpdateStatusAccountNotificationP;
use App\Services\CotationClient;
use App\Services\SlackNotifier;
use Illuminate\Console\Command;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

class SystemCustomerCommand extends Command
{
    use LaravelSchedulerCustomMutex;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        $this->setSignature('customer {action}');
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
            "updateCotation" => $this->updateCotation(),
            "executeActiveAccount" => $this->executeActiveAccount(),
        };

        return Command::SUCCESS;
    }

    private function updateCotation()
    {
        $cotation = new CotationClient();
        $customers = Customer::all();
        $arr = [];
        foreach ($customers as $customer) {
            $customer->update(['cotation' => $cotation->calc($customer)]);
            $arr[] = [
                "client" => $customer->info->full_name,
                "cotation" => $customer->cotation
            ];
        }
        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->output->table(["client", "cotation"], $arr);
        $this->slack->send("Cotation client", json_encode($arr));
    }
    private function executeActiveAccount()
    {
        $accounts = Customer::where('status_open_account', 'accepted')->get();
        $arr = [];

        foreach ($accounts as $account) {
            $account->update([
                'status_open_account' => 'terminated'
            ]);

            $account->info->notify(new UpdateStatusAccountNotification($account, "Comptes & Moyens de paiement"));

            $arr[] = [
                $account->info->full_name,
                "Accepted => Terminated",
            ];
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->output->table(['Client', "Etat"], $arr);
        $this->slack->send("Comptes Effectifs", json_encode($arr));
    }
}
