<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
use App\Notifications\Customer\ChargeLoanAcceptedNotification;
use App\Notifications\Customer\VerifRequestLoanNotification;
use App\Services\Stripe;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SystemCreditCommand extends Command
{
    protected $signature = 'credit {action}';

    protected $description = 'Command description';

    public function handle()
    {
        match ($this->argument('action')) {
            "verifRequestLoanOpen" => $this->verifRequestLoanOpen(),
            "chargeLoanAccepted" => $this->chargeLoanAccepted(),
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
}
