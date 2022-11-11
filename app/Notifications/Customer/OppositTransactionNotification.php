<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class OppositTransactionNotification extends Notification
{

    public Customer $customer;
    public CustomerTransaction $transaction;
    public string $raison;
    public string $title;
    public string $link;
    public string $message;

    /**
     * @param Customer $customer
     * @param CustomerTransaction $transaction
     * @param string $raison
     */
    public function __construct(Customer $customer, CustomerTransaction $transaction, string $raison)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
        $this->raison = $raison;
        $this->title = "Opposition sur un mouvement bancaire";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        $message = "<p>Une transaction d'un montant de {$this->transaction->amount_format} à fait l'objet d'une opposition par notre servbice financier en date du {$this->transaction->updated_at->format('d/m/Y')}.</p>";
        $message .= "<p>Aucun frais supplémentaire ne vous sera prélevé.</p>";
        $message .= "<p>La raison évoquer pour cette opposition est : {$this->raison}</p>";
        $message .= "<br>";
        $message .= "<p>Pour contester cette opposition, veuillez contacter votre conseiller bancaire.</p>";
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_sms) {
                return [FreeMobileChannel::class];
            }

            if($this->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        } else {

            if($this->customer->setting->notif_sms) {
                return [TwilioChannel::class];
            }

            if($this->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        }
    }

    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage);
        $message->view("emails.customer.opposit_transaction", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-ban",
            "color" => "danger",
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
}
