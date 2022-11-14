<?php
namespace App\Notifications\Customer\Alert;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SameDefaultPasswordNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->title = "Information relative à la sécurité de votre compte";
        $this->message = $this->getMessage();
        $this->link = route('customer.profil.security.password');
    }

    private function getMessage()
    {
        $message = "Depuis votre inscription, nous avons remarquer que le mot de passe qui vous à été fourni lors de l'ouverture de compte n'à pas été modifier.";
        $message .= "Puisque la sécurité de vos données restent notre priorité, veillez à modifier votre mot de passe dans les plus bref délai en cliquant sur le lien ci-dessous.";
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_mail) {
                return "mail";
            }
        } else {
            if($this->customer->setting->notif_mail) {
                return "mail";
            }
        }
    }

    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage);
        $message->subject($this->title);
        $message->view("emails.customer.same_default_password", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Modifier mon mot de passe";
        $message->actionUrl = $this->link;

        return $message;
    }
}
