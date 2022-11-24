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
        match ($this->argument('action')) {
            "activeWallet" => $this->activeWallet(),
        };

        return Command::SUCCESS;
    }

    private function activeWallet()
    {
        $wallets = CustomerWallet::where('');
    }
}
