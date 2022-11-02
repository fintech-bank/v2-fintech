<?php

namespace App\Notifications\Customer;

use App\Models\Customer\Customer;
use App\Models\Reseller\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;

class SendCodeNotification extends Notification
{
    use Queueable;

    public $action;
    public $code;

    /**
     * Create a new notification instance.
     *
     * @param $action
     * @param $code
     */
    public function __construct($action, $code)
    {
        //
        $this->action = $action;
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
        return [TwilioChannel::class];
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toTwilio($notifiable)
    {
        switch ($this->action) {
            case 'withdraw' || 'money':
                return (new TwilioSmsMessage())
                    ->content("Votre code pour le retrait ou dépot d'éspèce est le ".base64_decode($this->code));
                break;
        }
    }
}
