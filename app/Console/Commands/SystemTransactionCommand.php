<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use App\Scope\TransactionTrait;
use App\Services\SlackNotifier;
use Illuminate\Console\Command;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

class SystemTransactionCommand extends Command
{
    use LaravelSchedulerCustomMutex, TransactionTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        $this->setSignature('transaction {action}');
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
            "transactionComing" => $this->executeTransactionsComing()
        };

        return Command::SUCCESS;
    }

    private function executeTransactionsComing()
    {
        $transactions = CustomerTransaction::where('confirmed', false)
            ->where('differed', false)
            ->whereBetween('updated_at', [now()->startOfDay(), now()->endOfDay()])
            ->get();
        $i = 0;

        foreach ($transactions as $transaction) {
            if($transaction->verifAccountBalanceForTransaction($transaction)) {
                $this->comingToConfirmedTransaction($transaction);
            } else {
                match ($transaction->type) {
                    "depot" => $transaction->comingToConfirmedTransaction($transaction),
                    "autre", "frais" => $transaction->amount > 0 ? $this->comingToConfirmedTransaction($transaction) : null,
                    default => null
                };
            }
            $i++;
        }

        $this->slack->send("Nombre de transaction mise à jours", $i);
    }

}
