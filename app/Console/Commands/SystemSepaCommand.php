<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerCheck;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Notifications\Customer\ChargeLoanAcceptedNotification;
use App\Notifications\Customer\CheckoutPayNotification;
use App\Notifications\Customer\RejectSepaNotification;
use App\Notifications\Customer\UpdateCheckoutCheckNotification;
use App\Notifications\Customer\VerifRequestLoanNotification;
use App\Services\Fintech\Payment\Sepa;
use App\Services\SlackNotifier;
use App\Services\Stripe;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SystemSepaCommand extends Command
{
    protected $signature = 'sepa {action}';

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
            "processedSepa" => $this->processedSepa(),
        };

        return Command::SUCCESS;
    }

    private function processedSepa()
    {
        $api = new Sepa();
        $sepas = CustomerSepa::where('status', 'waiting')->get();

        foreach ($sepas as $sepa) {
            if($sepa->processed_time == now()->startOfDay()) {
                if($api->acceptSepa() == 1) {
                    $sepa->setAccepted();
                } else {
                    $sepa->setReturned();
                }
            }
        }
    }

}
