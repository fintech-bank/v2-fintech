<?php

namespace App\Notifications\Agent;

use App\Models\Core\Event;
use Illuminate\Notifications\Notification;

class NewEventNotification extends Notification
{
    private Event $event;

    /**
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function getMessage()
    {
        ob_start();
        ?>
        <p class="fw-bolder">Nouveau rendez-vous clientèle</p>
        <p>Une nouvelle demande de rendez-vous à été émis ce jour.<br>Voici les informations concernant ce rendez-vous:</p>
        <ul>
            <li><strong>Client:</strong> <?= $this->event->user->customers->info->full_name ?></li>
            <li><strong>Raison:</strong> <?= $this->event->reason ?></li>
            <li><strong>Canal:</strong> <?= $this->event->getCanal('text') ?></li>
            <li><strong>Date et heure:</strong> <?= formatDateFrench($this->event->start_at, true) ?></li>
        </ul>
        <?php
        return ob_get_clean();
    }

    public function toDatabase($notifiable): array
    {
        return [
            "icon" => "fa-calendar-plus",
            "color" => "info",
            "title" => "Nouveau rendez-vous clientèle",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => route('agent.account.agenda.index'),
            "category" => "Rendez-vous client",
            "models" => [$this->event]
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            "icon" => "fa-calendar-plus",
            "color" => "info",
            "title" => "Nouveau rendez-vous clientèle",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => route('agent.account.agenda.index'),
            "category" => "Rendez-vous client",
            "models" => [$this->event]
        ];
    }
}
