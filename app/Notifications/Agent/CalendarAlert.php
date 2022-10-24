<?php

namespace App\Notifications\Agent;

use App\Models\Core\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CalendarAlert extends Notification
{
    use Queueable;

    /**
     * @var Event
     */
    public $event;

    /**
     * Create a new notification instance.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        //
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', WebPushChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'icon' => 'fa-calendar',
            'color' => 'primary',
            'title' => "Alerte de rendez-vous",
            'text' => "Vous avez un rendez-vous de programmer dans 15 min: ".$this->event->title,
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            ->title('Alerte de rendez-vous')
            ->icon(public_path('/storage/logo/logo_carre_80.png'))
            ->body("Vous avez un rendez-vous de programmer dans 15 min: ".$this->event->title)
            ->action('Mon rendez-vous', route('agent.account.agenda.index'))
            ->options(['TTL' => 1000]);
        // ->data(['id' => $notification->id])
        // ->badge()
        // ->dir()
        // ->image()
        // ->lang()
        // ->renotify()
        // ->requireInteraction()
        // ->tag()
        // ->vibrate()
    }
}
