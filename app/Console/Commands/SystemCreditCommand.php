<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
use App\Notifications\Customer\ChargeLoanAcceptedNotification;
use App\Notifications\Customer\CheckoutPayNotification;
use App\Notifications\Customer\RejectSepaNotification;
use App\Notifications\Customer\VerifRequestLoanNotification;
use App\Services\Fintech\Payment\Sepa;
use App\Services\SlackNotifier;
use App\Services\Stripe;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SystemCreditCommand extends Command
{
    protected $signature = 'credit {action}';

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
            "verifRequestLoanOpen" => $this->verifRequestLoanOpen(),
            "chargeLoanAccepted" => $this->chargeLoanAccepted(),
            "prlvCreditMensuality" => $this->prlvCreditMensuality()
        };

        return Command::SUCCESS;
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

                        $pret->customer->info->notify(new VerifRequestLoanNotification($pret, "Prêt"));
                    }
                } else {
                    $pret->update([
                        'status' => 'study'
                    ]);

                    $pret->customer->info->notify(new VerifRequestLoanNotification($pret, "Prêt"));
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

                $pret->customer->info->notify(new ChargeLoanAcceptedNotification($pret->customer, $pret, "Prêt"));
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

                    $transaction->wallet->customer->info->notify(new RejectSepaNotification($transaction->wallet->customer, $sepa, "Comptes & Moyens de paiement"));
                    $transaction->wallet->customer->info->notify(new CheckoutPayNotification($transaction->wallet->customer, $sepa, $session->url));
                    $error++;
                }

            }
        }

        $this->slack->send("Préparation des prélèvement des mensualités de crédit", json_encode([strip_tags("Nombre de compte mise a jours: ").$prepare]));
        $this->slack->send("Prélèvement des mensualités de crédit", json_encode([strip_tags("Nombre de compte mise a jours: ").$pass]));
        $this->slack->send("Echec Prélèvement des mensualités de crédit", json_encode([strip_tags("Nombre de compte mise a jours: ").$error]));
    }
}
