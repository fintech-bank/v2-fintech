<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Models\Customer\CustomerWallet;
use App\Scope\TransactionTrait;
use App\Scope\TransfertTrait;
use App\Services\Fintech\Payment\Transfers;
use App\Services\SlackNotifier;
use Illuminate\Console\Command;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

class SystemTransferCommand extends Command
{
    use LaravelSchedulerCustomMutex, TransfertTrait, TransactionTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        $this->setSignature('transfer {action}');
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
            "executePending" => $this->executePending()
        };

        return Command::SUCCESS;
    }

    private function executePending()
    {
        $transfers = CustomerTransfer::where('status', 'pending')->get();
        $api = new Transfers();
        foreach ($transfers as $transfer) {
            match ($transfer->type) {
                "immediat" => $this->immediatTransfer($transfer),
                "differed" => $this->differedTransfer($transfer)
            };
        }
    }

}
