<?php

namespace App\Notifications\Calendar;

use App\Models\Core\Event;
use App\Models\Core\EventAttendee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewEventNotification extends Notification
{
    use Queueable;

    /**
     * @var Event
     */
    public $event;
    public $attendee;

    /**
     * Create a new notification instance.
     *
     * @param Event $event
     * @param $attendee
     */
    public function __construct(Event $event, EventAttendee $attendee)
    {
        //
        $this->event = $event;
        $this->attendee = $attendee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', WebPushChannel::class, FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage())->view('emails.calendar.new_event', [
            'event' => $this->event,
            'attendee' => $this->attendee
        ]);

        $message->subject("Votre rendez-vous");

        return $message;
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
            'title' => "Rendez-vous",
            'text' => "Vous avez rendez-vous le ".$this->event->start_at->format('d/m/Y à H:i'),
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            ->title('Rendez-vous')
            ->icon(public_path('/storage/logo/logo_carre_80.png'))
            ->body("Vous avez rendez-vous le ".$this->event->start_at->format('d/m/Y à H:i'),)
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
                ->setTitle("Rendez-vous")
                ->setBody("Vous avez rendez-vous le ".$this->event->start_at->format('d/m/Y à H:i'),)
                ->setImage(public_path('/storage/logo/logo_carre_80.png')))
            ->setAndroid(AndroidConfig::create()
                ->setNotification(AndroidNotification::create()->setColor('#0A0A0A')));
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'event_title' => $this->event->title
        ]);
    }
}
