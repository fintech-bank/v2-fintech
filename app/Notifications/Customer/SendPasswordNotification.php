<?php

namespace App\Notifications\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushbullet\PushbulletChannel;
use NotificationChannels\Pushbullet\PushbulletMessage;
use NotificationChannels\Pushover\PushoverChannel;

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
        return [PushbulletChannel::class];
    }


    public function toPushbullet($notifiable)
    {
        return PushbulletMessage::create('Votre mot de passe provisoire est: '.$this->password)
            ->note()
            ->title(config('app.name'));
    }
}
