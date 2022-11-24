<?php

namespace App\Console\Commands;

use App\Helper\CustomerSepaHelper;
use App\Helper\CustomerTransactionHelper;
use App\Jobs\Customer\AcceptSepaJob;
use App\Models\Core\Event;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Agent\CalendarAlert;
use App\Notifications\Customer\ChargeLoanAcceptedNotification;
use App\Notifications\Customer\CheckoutPayNotification;
use App\Notifications\Customer\RejectedTransferNotification;
use App\Notifications\Customer\RejectSepaNotification;
use App\Notifications\Customer\UpdateStatusAccountNotification;
use App\Notifications\Customer\VerifRequestLoanNotification;
use App\Services\CotationClient;
use App\Services\Fintech\Payment\Sepa;
use App\Services\Fintech\Payment\Transfers;
use App\Services\SlackNotifier;
use App\Services\Stripe;
use Carbon\Carbon;
use Illuminate\Console\Command;
use macropage\LaravelSchedulerWatcher\LaravelSchedulerCustomMutex;

class SystemAgentCommand extends Command
{
    use LaravelSchedulerCustomMutex;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:agent {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        $this->setSignature('system:agent {action}');
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
            "calendarAlert" => $this->calendarAlert(),
            "updateCotation" => $this->updateCotation(),
            "verifRequestLoanOpen" => $this->verifRequestLoanOpen(),
            "chargeLoanAccepted" => $this->chargeLoanAccepted(),
            "executeSepaOrders" => $this->executeSepaOrders(),
            "executeTransactionComing" => $this->executeTransactionComing(),
            "executeActiveAccount" => $this->executeActiveAccount(),
            "executeVirement" => $this->executeVirement(),
            "executeCalcProfitEpargne" => $this->executeCalcProfitEpargne(),
            "virProfitEpargne" => $this->virProfitEpargne(),
            "prlvCreditMensuality" => $this->prlvCreditMensuality()
        };

        return Command::SUCCESS;
    }

    private function calendarAlert()
    {
        $events = Event::all();

        foreach ($events as $event) {
            if ($event->start_at->subMinutes(15)->format('d/m/Y H:i') == now()->format('d/m/Y H:i')) {
                $event->user->notify(new CalendarAlert($event));
                foreach ($event->attendees as $attendee) {
                    $attendee->user->notify(new \App\Notifications\Customer\CalendarAlert($event));
                }
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
    }

    private function verifRequestLoanOpen()
    {
        $prets = CustomerPret::where('status', 'open')->get();
        $arr = [];

        foreach ($prets as $pret) {
            if(CustomerDocument::where('reference', $pret->reference)->where('signable', true)->where('signed_by_client', 0)->count() == 0) {
                if($pret->required_caution != 0) {
                    if($pret->cautions()->where('sign_caution', 0)->count() == 0) {
                        $pret->update([
                            'status' => 'study'
                        ]);

                        $pret->customer->info->notify(new VerifRequestLoanNotification($pret));
                    }
                } else {
                    $pret->update([
                        'status' => 'study'
                    ]);

                    $pret->customer->info->notify(new VerifRequestLoanNotification($pret));
                }
            }

            $arr[] = [
                $pret->customer->info->full_name,
                $pret->plan->name,
                $pret->reference,
                eur($pret->amount_loan),
                $pret->status
            ];
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->output->table(['Client', "Type de Pret", 'Référence', 'Montant', 'Etat'], $arr);
        $this->slack->send("Passage des demandes de pret bancaire", json_encode($arr));
    }

    private function chargeLoanAccepted()
    {
        $stripe = new Stripe();
        $prets = CustomerPret::where('status', 'accepted')->get();
        $arr = [];

        foreach ($prets as $pret) {
            if ($pret->confirmed_at->addDays(1)->startOfDay() == now()->startOfDay()) {

                CustomerTransactionHelper::createDebit(
                    $pret->wallet->id,
                    'autre',
                    $pret->wallet->name_account_generic,
                    $pret->wallet->name_account_generic." - Libération du crédit",
                    $pret->amount_loan,
                    true,
                    now(),
                );

                CustomerTransactionHelper::createCredit(
                    $pret->payment->id,
                    'autre',
                    $pret->wallet->name_account_generic,
                    $pret->wallet->name_account_generic." - Libération du crédit",
                    $pret->amount_loan,
                    true,
                    now(),
                );

                $pret->update([
                    'status' => 'progress',
                    'first_payment_at' => Carbon::create(now()->year, now()->addMonth()->month, $pret->prlv_day),
                ]);

                $pret->wallet->update([
                    'status' => 'active'
                ]);

                $pret->customer->info->notify(new ChargeLoanAcceptedNotification($pret->customer, $pret));
                $arr[] = [
                    $pret->customer->info->full_name,
                    $pret->plan->name,
                    $pret->reference,
                    eur($pret->amount_loan),
                    $pret->status
                ];
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->output->table(['Client', "Type de Pret", 'Référence', 'Montant', 'Etat'], $arr);
        $this->slack->send("Libération du montant des pret bancaire", json_encode($arr));
    }

    private function executeSepaOrders()
    {
        $s = new Sepa();
        $sepas = CustomerSepa::where('status', 'waiting')->get();

        foreach ($sepas as $sepa) {
            if ($sepa->amount >= $sepa->wallet->solde_remaining) {
                if ($sepa->updated_at->startOfDay() == now()->startOfDay()) {
                    $call = $s->acceptSepa();

                    if($call == 1) {
                        dispatch(new AcceptSepaJob($sepa));
                    }
                }
            } else {
                $sepa->update([
                    'status' => 'rejected'
                ]);

                CustomerTransactionHelper::createDebit(
                    $sepa->wallet->id,
                    'frais',
                    'Frais Bancaire',
                    "Frais rejet prélèvement - {$sepa->number_mandate}",
                    2.5,
                    true,
                    now()
                );
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->slack->send("Exécution des prélèvement SEPA");
    }

    private function executeTransactionComing()
    {
        $transactions = CustomerTransaction::where('confirmed', false)
            ->where('designation', 'NOT LIKE', '%Remise%')
            ->get();
        $arr_effect = [];
        $arr_reject = [];

        foreach ($transactions as $transaction) {
            if($transaction->opposit()->count() == 0) {
                if ($transaction->withdraw()->count() != 1) {
                    if ($transaction->updated_at->between(now()->startOfDay(), now()->endOfDay())) {
                        if ($transaction->amount <= $transaction->wallet->solde_remaining) {
                            CustomerTransactionHelper::updated($transaction);

                            $arr_effect[] = [
                                $transaction->wallet->customer->info->full_name,
                                $transaction->type_text,
                                $transaction->wallet->name_account_generic,
                                $transaction->amount_format,
                            ];

                        } else {
                            $arr_reject[] = [
                                $transaction->wallet->customer->info->full_name,
                                $transaction->type_text,
                                $transaction->wallet->name_account_generic,
                                $transaction->amount_format,
                                "Solde Insuffisant"
                            ];
                        }
                    }
                }
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->info("Liste des transactions entrante mise à jours");
        $this->output->table(['Client', 'Type', 'Compte', 'Montant'], $arr_effect);
        $this->slack->send("Liste des transactions entrante mise à jours", json_encode($arr_effect));

        $this->error("Liste des transactions entrante rejeté");
        $this->output->table(['Client', 'Type', 'Compte', 'Montant', "Raison"], $arr_reject);
        $this->slack->send("Liste des transactions entrante rejeté", json_encode($arr_reject));
    }

    private function executeVirement()
    {
        $transfer_transits = CustomerTransfer::where('status', 'in_transit')->get();
        $transfer_pendings = CustomerTransfer::where('status', 'pending')->get();
        $arr_transit_paid = [];
        $arr_transit_failed = [];
        $arr_pending_transit = [];
        $arr_pending_failed = [];

        foreach ($transfer_transits as $transit) {
            $transaction = CustomerTransaction::find($transit->transaction_id);
            match ($transit->type) {
                'immediat' => $this->immediateTransfer($transit, $transaction),
                'differed' => $this->differedTransfer($transit, $transaction),
            };

            if($transit->status == 'paid') {
                $arr_transit_paid[] = [
                    $transit->wallet->customer->info->full_name,
                    $transit->reference,
                    eur($transit->amount)
                ];
            } else {
                $arr_transit_failed[] = [
                    $transit->wallet->customer->info->full_name,
                    $transit->reference,
                    eur($transit->amount),
                    null
                ];
            }
        }

        foreach ($transfer_pendings as $pending) {
            $transaction = CustomerTransaction::find($pending->transaction_id);

            match ($transit->type) {
                'immediat' => $this->immediateTransfer($transit, $transaction),
                'differed' => $this->differedTransfer($transit, $transaction),
            };

            if($transit->status == 'in_transit') {
                $arr_transit_paid[] = [
                    $transit->wallet->customer->info->full_name,
                    $transit->reference,
                    eur($transit->amount)
                ];
            } else {
                $arr_transit_failed[] = [
                    $transit->wallet->customer->info->full_name,
                    $transit->reference,
                    eur($transit->amount),
                    null
                ];
            }
        }
        $this->line("Date: ".now()->format("d/m/Y à H:i"));
        $this->info("Passage des virements bancaire");
        $this->output->table(['Client', 'Reference', 'Montant'], $arr_transit_paid);
        $this->slack->send("Passage des virements bancaire", json_encode($arr_transit_paid));

        $this->info("Passage des virements bancaire en erreur");
        $this->output->table(['Client', 'Reference', 'Montant', "Raison"], $arr_transit_failed);
        $this->slack->send("Passage des virements bancaire en erreur", json_encode($arr_transit_failed));

        $this->info("Préparation des virements bancaire");
        $this->output->table(['Client', 'Reference', 'Montant'], $arr_transit_paid);
        $this->slack->send("Préparation des virements bancaire", json_encode($arr_transit_paid));

        $this->info("Préparation des virements bancaire en erreur");
        $this->output->table(['Client', 'Reference', 'Montant', "Raison"], $arr_transit_failed);
        $this->slack->send("Préparation des virements bancaire en erreur", json_encode($arr_transit_failed));
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

    private function prlvCreditMensuality()
    {
        $stripe = new Stripe();
        $s_sepa = new Sepa();
        $credits = CustomerPret::where('status', 'progress')->get();
        $prepare = 0;
        $pass = 0;
        $error = 0;

        foreach ($credits as $credit) {
            // Création du prélèvement SEPA en base et par stripe
            if($credit->first_payment_at->subDays(2)->startOfDay() == now()->startOfDay()) {
                $amount = $credit->insurance()->count() == 0 ? $credit->mensuality : $credit->mensuality + $credit->insurance->mensuality;
                $amort = $credit->amortissements()->where('date_prlv', $credit->first_payment_at->startOfDay())->first();
                $sepa = $amort->sepa;

                $transaction = CustomerTransactionHelper::createDebit(
                    $credit->payment->id,
                    'sepa',
                    $credit->wallet->name_account_generic." - Echéance {$amort->date_prlv->locale('fr')->monthName}",
                    $credit->wallet->name_account_generic." - Echéance {$amort->date_prlv->locale('fr')->monthName}",
                    $amount,
                );

                $sepa->update(['transaction_id' => $transaction->id]);
                $amort->update(['status' => 'progress']);
                $prepare++;
            }

            if($credit->first_payment_at->startOfDay() == now()->startOfDay()) {
                $amort = $credit->amortissements()->where('date_prlv', $credit->first_payment_at->startOfDay())->first();
                $sepa = $amort->sepa;
                $transaction = $sepa->transaction;

                if($s_sepa->acceptSepa()) {
                    CustomerTransactionHelper::updated($transaction);
                    $sepa->update(['status' => 'processed']);
                    $amort->update(['status' => 'finish']);
                    $pass++;
                } else {
                    CustomerTransactionHelper::deleteTransaction($transaction);
                    $sepa->update(['status' => 'rejected']);
                    $amort->update(['status' => 'error']);

                    $session = $stripe->client->checkout->sessions->create([
                        'cancel_url' => route('stripe.cancel'),
                        'mode' => 'payment',
                        'success_url' => route('stripe.success'),
                        'customer' => $transaction->wallet->customer->stripe_customer_id,
                        'line_items' => [
                            'price_data' => [
                                'currency' => 'eur',
                                'product_data' => [
                                    'name' => $transaction->designation
                                ],
                                'unit_amount' => $sepa->amount * 100,
                                ''
                            ],
                            'quantity' => 1
                        ],
                        'payment_method_types' => ['card', 'sepa_debit']
                    ]);

                    $transaction->wallet->customer->info->notify(new RejectSepaNotification($transaction->wallet->customer, $sepa));
                    $transaction->wallet->customer->info->notify(new CheckoutPayNotification($transaction->wallet->customer, $sepa, $session->url));
                    $error++;
                }

            }
        }

        $this->slack->send("Préparation des prélèvement des mensualités de crédit", json_encode([strip_tags("Nombre de compte mise a jours: ").$prepare]));
        $this->slack->send("Prélèvement des mensualités de crédit", json_encode([strip_tags("Nombre de compte mise a jours: ").$pass]));
        $this->slack->send("Echec Prélèvement des mensualités de crédit", json_encode([strip_tags("Nombre de compte mise a jours: ").$error]));
    }

    private function immediateTransfer(CustomerTransfer $transfer, CustomerTransaction $transaction)
    {
        $trans = new Transfers();
        if ($transfer->amount <= $transfer->wallet->solde_remaining) {
            if ($trans->callTransfer($transfer) == 201) {
                CustomerTransactionHelper::updated($transaction);

                $transfer->update([
                    'status' => $transfer->status == 'in_transit' ? 'paid' : 'in_transit'
                ]);

            } else {
                CustomerTransactionHelper::createDebit(
                    $transfer->wallet->id,
                    'frais',
                    "Commission d'intervention",
                    'Frais rejet de virement - '.$transfer->reference,
                    2.5,
                    true,
                    now()
                );

                CustomerTransactionHelper::deleteTransaction($transaction);

                $transfer->update([
                    'status' => 'failed'
                ]);

                $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Rejet de la banque distante"));
            }
        } else {
            CustomerTransactionHelper::createDebit(
                $transfer->wallet->id,
                'frais',
                "Commission d'intervention",
                'Frais rejet de virement - '.$transfer->reference,
                2.5,
                true,
                now()
            );

            CustomerTransactionHelper::deleteTransaction($transaction);

            $transfer->update([
                'status' => 'failed'
            ]);

            CustomerTransactionHelper::create(
                'debit',
                'frais',
                "Commission d'intervention",
                $transfer->amount * 1.25 / 100,
                $transfer->wallet->id,
                true,
                "Frais Rejet Virement bancaire | " . $transfer->reference,
                now()
            );

            $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Solde Insuffisant"));
        }
    }

    private function differedTransfer(CustomerTransfer $transfer, CustomerTransaction $transaction)
    {
        $trans = new Transfers();
        if ($transfer->amount <= $transfer->wallet->solde_remaining) {
            if ($transfer->transfer_date->startOfDay() == now()->startOfDay()) {
                if ($trans->callTransfer($transfer) == '201') {
                    CustomerTransactionHelper::createDebit(
                        $transfer->wallet->id,
                        'frais',
                        "Commission d'intervention",
                        'Frais rejet de virement - '.$transfer->reference,
                        2.5,
                        true,
                        now()
                    );
                    CustomerTransactionHelper::updated($transaction);
                    $transfer->update([
                        'status' => $transfer->status == 'in_transit' ? 'paid' : 'in_transit'
                    ]);
                } else {
                    CustomerTransactionHelper::deleteTransaction($transaction);
                    $transfer->update([
                        'status' => 'failed'
                    ]);
                    $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Rejet de la banque distante"));
                }
            }
        } else {
            CustomerTransactionHelper::deleteTransaction($transaction);

            $transfer->update([
                'status' => 'failed'
            ]);

            CustomerTransactionHelper::createDebit(
                $transfer->wallet->id,
                'frais',
                "Commission d'intervention",
                'Frais rejet de virement - '.$transfer->reference,
                2.5,
                true,
                now()
            );

            $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Solde Insuffisant"));
        }
    }
}
