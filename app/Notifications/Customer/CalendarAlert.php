<?php

namespace App\Notifications\Customer;

use App\Models\Core\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidNotification;
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
        return ['database', WebPushChannel::class, FcmChannel::class];
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
            'title' => "Rappel de rendez-vous",
            'text' => "Nous vous rappelons que vous avez un rendez-vous le <strong>".$this->event->start_at->format('d/m/Y à H:i')."</strong> avec <strong>".$this->event->user->name.".</strong>",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            ->title('Rappel de rendez-vous')
            ->icon(public_path('/storage/logo/logo_carre_80.png'))
            ->body("Nous vous rappelons que vous avez un rendez-vous le <strong>".$this->event->start_at->format('d/m/Y à H:i')."</strong> avec <strong>".$this->event->user->name.".</strong>")
            //->action('Mon rendez-vous', route('agent.account.agenda.index'))
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

    public function toFcm()
    {
        return FcmMessage::create()
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
            ->setTitle("Rappel de rendez-vous")
            ->setBody("Nous vous rappelons que vous avez un rendez-vous le <strong>".$this->event->start_at->format('d/m/Y à H:i')."</strong> avec <strong>".$this->event->user->name.".</strong>")
            ->setImage(public_path('/storage/logo/logo_carre_80.png')))
            ->setAndroid(AndroidConfig::create()
            ->setNotification(AndroidNotification::create()->setColor('#0A0A0A')));
    }
}
