<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendCodeSignApiNotification extends Notification
{

    public string $message;
    public string $code;

    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->message = $this->getMessage();
        $this->code = $code;
    }

    private function getMessage()
    {
        $message = "Le code pour signer votre document est: {$this->code}";
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            return [FreeMobileChannel::class];
        } else {
            return [TwilioChannel::class];
        }
    }

    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    public function toFreeMobile($notifiable)
    {
        $message = (new FreeMobileMessage());
        $message->message(strip_tags($this->message));

        return $message;
    }

    public function toTwilio($notifiable)
    {
        $message = (new TwilioSmsMessage());
        $message->content(strip_tags($this->message));

        return $message;
    }
}
