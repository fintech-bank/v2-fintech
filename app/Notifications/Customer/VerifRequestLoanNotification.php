<?php
namespace App\Notifications\Customer\Customer\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerPret;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class VerifRequestLoanNotification extends Notification
{

    private CustomerPret $pret;
    public string $title;
    public string $link;
    public string $message;

    public function __construct(CustomerPret $pret)
    {
        $this->pret = $pret;
        $this->title = "Votre demande de pret bancaire";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        $message = "Votre demande de pret <strong>N°".$this->pret->reference."</strong> à été enregistré en date du <strong>".$this->pret->created_at->format('d/m/Y')."</strong> et est maintenant en cours d'étude.";
        $message .= "Une notification vous sera envoyer lors de son acceptation ou de son refus par le service financier.";
        return $message;
    }

    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage);
        $message->subject($this->title)
            ->view('emails.customer.verif_request_loan', [
                'pret' => $this->pret,
                'content' => $this->message,
                'customer' => $this->pret->customer
            ]);

        $message->actionUrl = $this->link;
        $message->actionText = "Plus d'information";

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-euro-sign",
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
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

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->pret->customer->setting->notif_sms) {
                return [FreeMobileChannel::class];
            }

            if($this->pret->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        } else {

            if($this->pret->customer->setting->notif_sms) {
                return [TwilioChannel::class];
            }

            if($this->pret->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        }
    }
}

