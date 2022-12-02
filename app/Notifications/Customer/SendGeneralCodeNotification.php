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

class SendGeneralCodeNotification extends Notification
{

    public string $message;
    public Customer $customer;
    private int $code;

    /**
     * @param Customer $customer
     * @param int $code
     */
    public function __construct(Customer $customer, int $code)
    {
        $this->customer = $customer;
        $this->code = $code;
        $this->message = $this->getMessage();
    }

    private function getMessage()
    {
        $message = "Le code d'authentification est le: {$this->code}";
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
