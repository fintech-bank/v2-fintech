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

    public function toDatabase($notifiable): array
    {
        return [];
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
