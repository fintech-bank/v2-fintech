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

class RejectSepaNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerSepa $sepa;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerSepa $sepa
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerSepa $sepa, string $category)
    {
        $this->customer = $customer;
        $this->sepa = $sepa;
        $this->title = "Rejet d'un prélèvement bancaire";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        $message = "Le prélèvement bancaire <strong>{$this->sepa->number_mandate}</strong> d'un montant de <strong>{$this->sepa->amount_format}</strong> de <strong>{$this->sepa->creditors()->first()->name}</strong> à été rejeté par notre equipe financiere.";
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_mail) {
                return ["mail", "database"];
            }

            return "database";
        } else {
            if($this->customer->setting->notif_mail) {
                return ["mail", "database"];
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
        $message->view("emails.customer.reject_sepa", [
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
            "category" => $this->category,
            "models" => [$this->customer, $this->sepa]
        ];
    }
}
