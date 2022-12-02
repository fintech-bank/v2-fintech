<?php

namespace App\Notifications\Agent;

use App\Models\Core\Event;
use App\Models\Customer\CustomerGrpdDemande;
use Illuminate\Notifications\Notification;

class NewGrpdNotification extends Notification
{
    private CustomerGrpdDemande $demande;

    /**
     * @param CustomerGrpdDemande $demande
     */
    public function __construct(CustomerGrpdDemande $demande)
    {
        $this->demande = $demande;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function getMessage()
    {
        ob_start();
        ?>
        <p class="fw-bolder">Nouvelle demande d'accès aux données utilisateur</p>
        <ul>
            <li><strong>Client:</strong> <?= $this->demande->customer->info->full_name ?></li>
            <li><strong>Date de la demande:</strong> <?= $this->demande->created_at->format('d/m/Y à H:i') ?></li>
            <li><strong>Objet de la demande:</strong> <?= $this->demande->object ?></li>
            <li><strong>Information:</strong> <?= $this->demande->comment ?></li>
        </ul>
        <?php
        return ob_get_clean();
    }

    public function toDatabase($notifiable): array
    {
        return [
            "icon" => "fa-fa-user-shield",
            "color" => "info",
            "title" => "Nouvelle demande d'accès aux données utilisateur",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => '',
            "category" => "Demande GRPD",
            "models" => [$this->demande]
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            "icon" => "fa-fa-user-shield",
            "color" => "info",
            "title" => "Nouvelle demande d'accès aux données utilisateur",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => '',
            "category" => "Demande GRPD",
            "models" => [$this->demande]
        ];
    }
}
