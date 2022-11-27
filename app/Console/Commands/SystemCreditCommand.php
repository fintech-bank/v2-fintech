<?php

namespace App\Console\Commands;

use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
use App\Notifications\Customer\VerifRequestLoanNotification;
use Illuminate\Console\Command;

class SystemCreditCommand extends Command
{
    protected $signature = 'credit {action}';

    protected $description = 'Command description';

    public function handle()
    {
        match ($this->argument('action')) {
            "verifRequestLoanOpen" => $this->verifRequestLoanOpen()
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
}
