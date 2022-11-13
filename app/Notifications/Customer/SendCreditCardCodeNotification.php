<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendCreditCardCodeNotification extends Notification
{

    public string $message;
    public Customer $customer;
    public int $card_code;
    public CustomerCreditCard $card;

    /**
     * @param Customer $customer
     * @param int $card_code
     * @param CustomerCreditCard $card
     */
    public function __construct(Customer $customer, int $card_code, CustomerCreditCard $card)
    {
        $this->customer = $customer;
        $this->card_code = $card_code;
        $this->card = $card;
        $this->message = $this->getMessage();

    }

    private function getMessage()
    {
        $message = "Le code de votre carte bancaire ".$this->card->number_card_oscure." est le {$this->card_code}";
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
