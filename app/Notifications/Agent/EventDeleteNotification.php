<?php

namespace App\Notifications\Agent;

use App\Models\Core\Event;
use Illuminate\Notifications\Notification;

class EventDeleteNotification extends Notification
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
        <p>Votre rendez-vous avec <strong><?= $this->event->user->customers->info->full_name ?></strong> à été annulée.</p>
        <?php
        return ob_get_clean();
    }

    public function toDatabase($notifiable): array
    {
        return [
            "icon" => "fa-calendar-xmark",
            "color" => "danger",
            "title" => "Annulation d'un rendez-vous client",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => '',
            "category" => "Rendez-vous client",
            "models" => [$this->event]
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            "icon" => "fa-calendar-xmark",
            "color" => "danger",
            "title" => "Annulation d'un rendez-vous client",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => '',
            "category" => "Rendez-vous client",
            "models" => [$this->event]
        ];
    }
}
