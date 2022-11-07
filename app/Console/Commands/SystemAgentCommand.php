<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Models\Core\Event;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Notifications\Agent\CalendarAlert;
use App\Notifications\Customer\ChargeLoanAcceptedNotification;
use App\Notifications\Customer\VerifRequestLoanNotification;
use App\Services\CotationClient;
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
            "executeSepaOrders" => $this->executeSepaOrders()
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

        $this->output->table(['Client', "Type de Pret", 'Référence', 'Montant', 'Etat'], $arr);
    }

    private function chargeLoanAccepted()
    {
        $prets = CustomerPret::where('status', 'accepted')->get();
        $arr = [];

        foreach ($prets as $pret) {
            if($pret->updated_at > now()->addDays(8)) {
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

        $this->output->table(['Client', "Type de Pret", 'Référence', 'Montant', 'Etat'], $arr);
    }

    private function executeSepaOrders()
    {
        $sepas = CustomerSepa::where('status', 'waiting')->get();

        foreach ($sepas as $sepa) {
            if($sepa->amount >= $sepa->wallet->solde_remaining) {
                if($sepa->updated_at->startOfDay() == now()->startOfDay()) {
                    CustomerTransactionHelper::create(
                        'debit',
                        'sepa',
                        'Prélèvement SEPA '.$sepa->number_mandate." DE: ".$sepa->creditor,
                        $sepa->amount,
                        $sepa->wallet->id,
                        true,
                        'PRLV EUROPEEN SEPA DE: '.$sepa->creditor.' ID: '.$sepa->uuid.' MANDAT '.$sepa->number_mandate,
                        now(),
                    );

                    $sepa->update([
                        'status' => 'processed'
                    ]);
                }
            } else {
                $sepa->update([
                    'status' => 'rejected'
                ]);


            }

        }
    }
}
