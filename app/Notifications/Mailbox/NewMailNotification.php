<?php

namespace App\Notifications\Mailbox;

use App\Models\Core\Mailbox;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewMailNotification extends Notification
{
    use Queueable;

    public $mailbox;

    /**
     * Create a new notification instance.
     *
     * @param $mailbox
     */
    public function __construct(Mailbox $mailbox)
    {
        //
        $this->mailbox = $mailbox;
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
            'icon' => 'fa-envelope',
            'color' => 'primary',
            'title' => "Vous avez reçu un nouveau message",
            'text' => "Vous avez reçu un nouveau message dans votre messagerie sécurisée. Nous vous invitons à le consulter en cliquant sur la rubrique 'Messagerie'.",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            ->title('Vous avez reçu un nouveau message !')
            ->icon('/approved-icon.png')
            ->body("Vous avez reçu un nouveau message dans votre messagerie sécurisée. Nous vous invitons à le consulter en cliquant sur la rubrique 'Messagerie'.")
            ->action('Boite de reception', $this->getRouteForGroup($this->mailbox->sender))
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

    private function getRouteForGroup(User $user)
    {
        if($user->admin == 1) {
            return route('admin.account.mailbox.index');
        } elseif($user->agent == 1) {
            return route('agent.account.mailbox.index');
        } elseif($user->customer == 1) {
            return route('customer.account.mailbox.index');
        } else {
            return route('part.home');
        }
    }
}
