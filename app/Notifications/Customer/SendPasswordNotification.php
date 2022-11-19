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

class SendPasswordNotification extends Notification
{

    public string $message;
    public string $password;
    public Customer $customer;
    public string $identifiant;

    /**
     * @param Customer $customer
     * @param string $password
     * @param string $identifiant
     */
    public function __construct(Customer $customer, string $password, string $identifiant)
    {
        $this->customer = $customer;
        $this->password = $password;
        $this->identifiant = $identifiant;
        $this->message = $this->getMessage();
    }

    private function getMessage()
    {
        $message = config('app.name')."\n\r";
        $message .= "Afin de vous connecter à votre espace, voici vos identifiants:\n\r";
        $message .= "Identifiant: ".$this->identifiant."\n\r";
        $message .= "Mot de passe: ".$this->password."\n\r";
        $message .= "Veillez à changer votre mot de passe dès la première connexion.";
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
