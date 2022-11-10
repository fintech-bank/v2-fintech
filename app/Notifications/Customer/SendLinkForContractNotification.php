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

class SendLinkForContractNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $token;
    public $doc;

    /**
     * @param Customer $customer
     * @param string $token
     * @param $doc
     */
    public function __construct(Customer $customer, string $token, $doc)
    {
        $this->title = "Nouveau document en attente de signature";
        $this->message = $this->getMessage();
        $this->token = $token;
        $this->link = route('signate.show', $token);
        $this->customer = $customer;
        $this->doc = $doc;
    }

    private function getMessage()
    {
        $message = "Un nouveau document eléctronique est en attente de signature: <strong>{$this->doc->name}</strong>.";
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
        $message->view("emails.customer.link_for_contract", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Signer le document";
        $message->actionUrl = $this->link;

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-signate",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
