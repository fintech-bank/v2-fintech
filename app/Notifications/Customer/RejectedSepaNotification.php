<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class RejectedSepaNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerSepa $sepa;
    private string $reason;

    /**
     * @param Customer $customer
     * @param CustomerSepa $sepa
     * @param string $reason
     */
    public function __construct(Customer $customer, CustomerSepa $sepa, string $reason)
    {
        $this->title = "Rejet d'un prélèvement SEPA";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->customer = $customer;
        $this->sepa = $sepa;
        $this->reason = $reason;
    }

    private function getMessage()
    {
        $message = "Un prélèvement à fait l'objet d'un rejet en date du <strong>".$this->sepa->updated_at->format('d/m/Y à H:i').".</strong><br>";
        $message .= "Voici les informations relatives à ce rejet:<br>";
        $message .= "<ul>
                        <li>Mandat: ".$this->sepa->number_mandate."</li>
                        <li>Créancier: ".$this->sepa->creditor."</li>
                        <li>Montant: ".$this->sepa->amount_format."</li>
                        <li>Raison du rejet: <span class='text-danger'>".$this->sepa->getReasonFromRejected($this->reason)."</span></li>
                    </ul>";
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
        $message->view("emails.customer.reject_sepa", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-exclamation-triangle",
            "color" => "warning",
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
