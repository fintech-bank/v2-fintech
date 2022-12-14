<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerSepa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class RefundSepaNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerSepa $sepa;

    /**
     * @param Customer $customer
     * @param CustomerSepa $sepa
     */
    public function __construct(Customer $customer, CustomerSepa $sepa)
    {
        $this->customer = $customer;
        $this->sepa = $sepa;
        $this->title = "Remboursement d'un prélèvement bancaire";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        $message = "Le prélèvement bancaire <strong>{$this->sepa->number_mandate}</strong> d'un montant de <strong>{$this->sepa->amount_format}</strong> à fait l'objet d'un remboursement.";
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        } else {
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
        $message->subject($this->title);
        $message->view("emails.customer.refund_sepa", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "money-bill-transfer",
            "color" => "success",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
