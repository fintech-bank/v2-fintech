<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendSecurePassCodeNotification extends Notification
{
    use Queueable;

    private $code;

    /**
     * Create a new notification instance.
     *
     * @param $code
     */
    public function __construct($code)
    {
        //
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
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
            ->line("Votre code SECUREPASS est: " . $this->code);
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Votre code SECUREPASS est: ".$this->code);
    }

    private function choiceChannel()
    {
        if(config('app.env') == 'local') {
            return ['mail'];
        } else {
            return [TwilioChannel::class];
        }
    }
}
