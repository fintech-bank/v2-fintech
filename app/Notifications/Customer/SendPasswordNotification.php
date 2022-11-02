<?php

namespace App\Notifications\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushbullet\PushbulletChannel;
use NotificationChannels\Pushbullet\PushbulletMessage;
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

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
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->choiceChannel();
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Votre mot de passe")
            ->line("Votre mot de passe est: " . $this->password);
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Votre mot de passe provisoire: " . $this->password);
    }

    private function choiceChannel()
    {
        if (config('app.env') == 'local') {
            return ['mail'];
        } else {
            return [TwilioChannel::class];
        }
    }
}
