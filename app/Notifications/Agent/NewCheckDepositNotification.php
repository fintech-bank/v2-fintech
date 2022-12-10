<?php

namespace App\Notifications\Agent;

use App\Models\Core\Event;
use App\Models\Customer\CustomerCheckDeposit;
use App\Models\Customer\CustomerGrpdDemande;
use Illuminate\Notifications\Notification;

class NewCheckDepositNotification extends Notification
{
    private CustomerCheckDeposit $deposit;

    /**
     * @param CustomerCheckDeposit $deposit
     */
    public function __construct(CustomerCheckDeposit $deposit)
    {
        $this->deposit = $deposit;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function getMessage()
    {
        ob_start();
        ?>
        <p class="fw-bolder">Nouvelle remise bancaire à vérifier</p>
        <ul>
            <li><strong>Client:</strong> <?= $this->deposit->wallet->customer->info->full_name ?></li>
            <li><strong>Référence:</strong> <?= $this->deposit->reference ?></li>
            <li><strong>Montant:</strong> <?= eur($this->deposit->amount) ?></li>
            <li><strong>Nombre de chèque:</strong> <?= $this->deposit->lists()->count() ?></li>
        </ul>
        <?php
        return ob_get_clean();
    }

    public function toDatabase($notifiable): array
    {
        return [
            "icon" => "fa-money-check",
            "color" => "info",
            "title" => "Nouvelle remise bancaire à vérifier",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => '',
            "category" => "Remise Bancaire",
            "models" => [$this->deposit]
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            "icon" => "fa-money-check",
            "color" => "info",
            "title" => "Nouvelle remise bancaire à vérifier",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => '',
            "category" => "Remise Bancaire",
            "models" => [$this->deposit]
        ];
    }
}
