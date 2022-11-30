<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Jobs\Customer\AcceptSepaJob;
use App\Models\Core\Event;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Notifications\Agent\CalendarAlert;
use App\Notifications\Customer\RejectedTransferNotification;
use App\Services\Fintech\Payment\Sepa;
use App\Services\Fintech\Payment\Transfers;
use App\Services\SlackNotifier;
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
            "executeSepaOrders" => $this->executeSepaOrders(),
            "executeTransactionComing" => $this->executeTransactionComing(),
            "executeVirement" => $this->executeVirement(),
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
                    $attendee->user->notify(new \App\Notifications\Customer\CalendarAlertP($event));
                }
            }
        }

        $this->line("Date: ".now()->format("d/m/Y à H:i"));
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

                $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Rejet de la banque distante", "Comptes & Moyens de paiement"));
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

            $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Solde Insuffisant", "Comptes & Moyens de paiement"));
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
                    $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Rejet de la banque distante", "Comptes & Moyens de paiement"));
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

            $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Solde Insuffisant", "Comptes & Moyens de paiement"));
        }
    }
}
