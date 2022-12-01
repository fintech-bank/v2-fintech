<?php

namespace App\Notifications\Agent;

use App\Models\Core\Event;
use App\Models\Core\EventMessage;
use App\Models\Customer\Customer;
use Illuminate\Notifications\Notification;

class EventUpdateNotification extends Notification
{
    private Customer $customer;
    private EventMessage $message;
    private Event $event;

    /**
     * @param Customer $customer
     * @param EventMessage $message
     * @param Event $event
     */
    public function __construct(Customer $customer, EventMessage $message, Event $event)
    {
        $this->customer = $customer;
        $this->message = $message;
        $this->event = $event;
    }

    public function getMessage()
    {
        ob_start();
        ?>
        <p>Un nouveau message à été ajouté a un rendez-vous clientèle. Voici un récapitulatif:</p>
        <ul>
            <li><strong>Client:</strong> <?= $this->customer->info->full_name ?></li>
            <li><strong>Date et heure du rendez-vous:</strong> <?= formatDateFrench($this->event->start_at) ?></li>
        </ul>
        <span class="fw-bolder">Message:</span><br>
        <?= $this->message->message ?>
        <?php
        return ob_get_clean();
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [];
    }

    public function toArray($notifiable): array
    {
        return [
            "icon" => "fa-calendar-check",
            "color" => "warning",
            "title" => "Nouvelle informations concernant un rendez-vous",
            "text" => $this->getMessage(),
            "time" => now(),
            "link" => '',
            "category" => "Rendez-vous client",
            "models" => [$this->customer, $this->event]
        ];
    }
}
