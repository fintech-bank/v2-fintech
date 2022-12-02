<?php

namespace App\Jobs\User;

use App\Helper\DocumentFile;
use App\Models\Customer\CustomerGrpdDemande;
use App\Models\User;
use App\Notifications\Customer\GrpdUpdateDroitAcceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DroitAccessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;
    private CustomerGrpdDemande $demande;
    private string $type;

    /**
     * @param User $user
     * @param CustomerGrpdDemande $demande
     * @param string $type
     */
    public function __construct(User $user, CustomerGrpdDemande $demande, string $type)
    {
        $this->user = $user;
        $this->demande = $demande;
        $this->type = $type;
    }

    public function handle()
    {
        // Génération du pdf
        if($this->type == 'identity') {
            $document = DocumentFile::createDoc(
                $this->user->customers,
                'user.grpd_droit_acces_perso',
                "GRPD - Donnees d identification et de situation personnelle",
                5,
                generateReference(),
                false,
                false,
                false,
                true,
            );
        } else {
            $document = DocumentFile::createDoc(
                $this->user->customers,
                'user.grpd_droit_acces_subscription',
                "GRPD - Données sur les produits et les contrats détenues",
                5,
                generateReference(),
                false,
                false,
                false,
                true,
            );
        }

        if($document) {
            $this->demande->update([
                'status' => 'terminated'
            ]);
        } else {
            $this->demande->update([
                'status' => 'rejected'
            ]);
        }

        $this->user->customers->info->notify(new GrpdUpdateDroitAcceNotification($this->user->customers, $this->demande, 'Contact avec votre banque'));
    }
}
