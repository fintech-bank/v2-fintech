<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Jobs\Customer\AcceptSepaJob;
use App\Models\Core\Event;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Notifications\Agent\CalendarAlert;
use App\Notifications\Customer\ChargeLoanAcceptedNotification;
use App\Notifications\Customer\RejectedTransferNotification;
use App\Notifications\Customer\UpdateStatusAccountNotification;
use App\Notifications\Customer\VerifRequestLoanNotification;
use App\Services\CotationClient;
use App\Services\Fintech\Payment\Sepa;
use App\Services\Fintech\Payment\Transfers;
use Illuminate\Console\Command;

class SystemAgentCommand extends Command
{
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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        match ($this->argument('action')) {
            "calendarAlert" => $this->calendarAlert(),
            "updateCotation" => $this->updateCotation(),
            "verifRequestLoanOpen" => $this->verifRequestLoanOpen(),
            "chargeLoanAccepted" => $this->chargeLoanAccepted(),
            "executeSepaOrders" => $this->executeSepaOrders(),
            "executeTransactionComing" => $this->executeTransactionComing(),
            "executeActiveAccount" => $this->executeActiveAccount(),
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
                    $attendee->user->notify(new \App\Notifications\Customer\CalendarAlert($event));
                }
            }
        }
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
        $this->output->table(["client", "cotation"], $arr);
    }

    private function verifRequestLoanOpen()
    {
        $prets = CustomerPret::where('status', 'open')->get();
        $arr = [];

        foreach ($prets as $pret) {
            $pret->update([
                'status' => 'study'
            ]);

            $pret->customer->info->notify(new VerifRequestLoanNotification($pret));
            $arr[] = [
                $pret->customer->info->full_name,
                $pret->plan->name,
                $pret->reference,
                eur($pret->amount_loan),
                $pret->status
            ];
        }

        $this->output->table(['Client', "Type de Pret", 'R??f??rence', 'Montant', 'Etat'], $arr);
    }

    private function chargeLoanAccepted()
    {
        $prets = CustomerPret::where('status', 'accepted')->get();
        $arr = [];

        foreach ($prets as $pret) {
            if ($pret->updated_at > now()->addDays(8)) {
                $pret->wallet->update([
                    'balance_coming' => $pret->wallet->balance_coming - $pret->amount_loan,
                    'balance_actual' => $pret->wallet->balance_actual + $pret->amount_loan
                ]);

                $pret->customer->info->notify(new ChargeLoanAcceptedNotification($pret));
                $arr[] = [
                    $pret->customer->info->full_name,
                    $pret->plan->name,
                    $pret->reference,
                    eur($pret->amount_loan),
                    $pret->status
                ];
            }
        }

        $this->output->table(['Client', "Type de Pret", 'R??f??rence', 'Montant', 'Etat'], $arr);
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

                CustomerTransactionHelper::create(
                    'debit',
                    'frais',
                    "Frais Bancaire",
                    2.5,
                    $sepa->wallet->id,
                    true,
                    "Frais rejet pr??l??vement - {$sepa->number_mandate}",
                    now()
                );
            }
        }
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

        $this->info("Liste des transactions entrante mise ?? jours");
        $this->output->table(['Client', 'Type', 'Compte', 'Montant'], $arr_effect);

        $this->error("Liste des transactions entrante rejet??");
        $this->output->table(['Client', 'Type', 'Compte', 'Montant', "Raison"], $arr_reject);
    }

    private function executeActiveAccount()
    {
        $accounts = Customer::where('status_open_account', 'accepted')->get();
        $arr = [];

        foreach ($accounts as $account) {
            $account->update([
                'status_open_account' => 'terminated'
            ]);

            $account->info->notify(new UpdateStatusAccountNotification($account, $account->status_open_account));

            $arr[] = [
                $account->info->full_name,
                "Accepted => Terminated",
            ];
        }

        $this->output->table(['Client', "Etat"], $arr);
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
        $this->info("Passage des virements bancaire");
        $this->output->table(['Client', 'Reference', 'Montant'], $arr_transit_paid);

        $this->info("Passage des virements bancaire en erreur");
        $this->output->table(['Client', 'Reference', 'Montant', "Raison"], $arr_transit_failed);

        $this->info("Pr??paration des virements bancaire");
        $this->output->table(['Client', 'Reference', 'Montant'], $arr_transit_paid);

        $this->info("Pr??paration des virements bancaire en erreur");
        $this->output->table(['Client', 'Reference', 'Montant', "Raison"], $arr_transit_failed);
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
                CustomerTransactionHelper::deleteTransaction($transaction);

                $transfer->update([
                    'status' => 'failed'
                ]);

                $transfer->wallet->customer->info->notify(new RejectedTransferNotification($transfer->wallet->customer, $transfer, "Rejet de la banque distante"));
            }
        } else {
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
}
