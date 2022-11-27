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
            "processedTransaction" => $this->processedTransaction()
        };

        return Command::SUCCESS;
    }

    private function processedSepa()
    {
        $api = new Sepa();
        $sepas = CustomerSepa::where('status', 'waiting')->get();
        $i_accept = 0;
        $i_return = 0;
        $i_reject = 0;

        foreach ($sepas as $sepa) {
            if($sepa->processed_time == now()->startOfDay()) {
                if($api->acceptSepa() == 1) {
                    if($sepa->wallet->solde_remaining <= 0) {
                        $sepa->setRejected();
                        $i_reject++;
                    } else {
                        $sepa->setAccepted();
                        $i_accept++;
                    }
                } else {
                    $sepa->setReturned();
                    $i_return++;
                }
            }
        }

        $this->slack->send("Prélèvement bancaire", json_encode([strip_tags("Nombre de prélèvement accepté: ").$i_accept]));
        $this->slack->send("Prélèvement bancaire", json_encode([strip_tags("Nombre de prélèvement retourné: ").$i_return]));
        $this->slack->send("Prélèvement bancaire", json_encode([strip_tags("Nombre de prélèvement rejeté: ").$i_reject]));
    }
    private function processedTransaction()
    {
        $sepas = CustomerSepa::where('status', 'waiting')->get();
        $i = 0;

        foreach ($sepas as $sepa) {
            if($sepa->processed_time->subDay() == now()->startOfDay()) {
                $transaction = CustomerTransactionHelper::createDebit(
                    $sepa->wallet->id,
                    'sepa',
                    "PRLV SEPA {$sepa->number_mandate} DE: {$sepa->creditor}",
                    "Motif: PRLV SEPA {$sepa->number_mandate} DE: {$sepa->creditor} | REF: {$sepa->number_mandate}",
                    \Str::replace('-', '', $sepa->amount),
                );

                $sepa->update(['transaction_id' => $transaction->id]);
                $i++;
            }
        }

        $this->slack->send("Création des transactions pour Prélèvement bancaire", json_encode([strip_tags("Nombre de transaction mise a jours: ").$i]));
    }

}
