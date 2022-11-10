<?php

namespace App\Notifications\Customer\Customer\Testing\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushbullet\PushbulletChannel;
use NotificationChannels\Pushbullet\PushbulletMessage;
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class SendPasswordNotification extends Notification
{
    use Queueable;

    /**
     * @var Customer
     */
    public $customer;
    /**
     * @var string|string
     */
    public $password;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param string $password
     */
    public function __construct(Customer $customer, string $password)
    {
        //
        $this->customer = $customer;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }


    public function toWebPush($notifiable)
    {
        return (new WebPushMessage)
            ->title(config('app.name')." - Votre mot de passe temporaire")
            ->icon(public_path().'/storage/icon/user-password.png')
            ->body("Votre mot de passe temporaire est: $this->password");
    }
}
