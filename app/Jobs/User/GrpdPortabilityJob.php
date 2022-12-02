<?php

namespace App\Jobs\User;

use App\Helper\DocumentFile;
use App\Models\Customer\CustomerGrpdDemande;
use App\Models\User;
use App\Notifications\Customer\GrpdPortabilityDocNotification;
use App\Notifications\Customer\GrpdUpdateDroitAcceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GrpdPortabilityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;
    private CustomerGrpdDemande $demande;

    /**
     * @param User $user
     * @param CustomerGrpdDemande $demande
     */
    public function __construct(User $user, CustomerGrpdDemande $demande)
    {
        $this->user = $user;
        $this->demande = $demande;
    }

    public function handle()
    {
        if($this->demande->status == 'pending') {
            $document = new DocumentFile();
            $document->generatePDF(
                'customer.certification_fiscal',
                $this->user->customers,
                null,
                [],
                false,
                true,
                public_path('/uploads/portability'),
                false,
            );
            $document->generatePDF(
                'customer.synthese_echange',
                $this->user->customers,
                null,
                ["card" => $this->user->customers->wallets()->first()->cards()->first()],
                false,
                true,
                public_path('/uploads/portability'),
                false,
            );
            $document->generatePDF(
                'general.fiche_de_dialogue',
                $this->user->customers,
                null,
                [],
                false,
                true,
                public_path('/uploads/portability'),
                false,
            );

            $this->demande->update(['status' => 'terminated']);
            $this->user->customers->info->notify(new GrpdUpdateDroitAcceNotification($this->user->customers, $this->demande, "Contact avec votre banque"));
            $this->user->customers->info->notify(new GrpdPortabilityDocNotification($this->user->customers, "Contact avec votre banque"));
        }
    }
}
