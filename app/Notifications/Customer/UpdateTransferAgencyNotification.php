<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransferAgency;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class UpdateTransferAgencyNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;
    private CustomerTransferAgency $transferAgency;

    /**
     * @param Customer $customer
     * @param CustomerTransferAgency $transferAgency
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerTransferAgency $transferAgency, string $category)
    {
        $this->customer = $customer;
        $this->transferAgency = $transferAgency;
        $this->title = "Votre transfert d'agence N°{$this->transferAgency->reference}";
        $this->message = $this->getMessage();
        $this->link = route('customer.account.profil.transfer.index');
        $this->category = $category;
    }

    private function getMessage()
    {
        return match ($this->transferAgency->status) {
            "progress" => $this->progress(),
            "terminated" => $this->terminated(),
            default => $this->failed()
        };
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
        $message->view("emails.customer.update_transfer_agency", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Suivre votre transfert d'agence";
        $message->actionUrl = $this->link;

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-building",
            "color" => "warning",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->transferAgency]
        ];
    }

    private function progress()
    {
        ob_start();
        ?>
        <p>Votre demande de transfers d'agence est actuellement <strong>en cours de traitement</strong>.</p>
        <?php
        return ob_get_clean();
    }

    private function terminated()
    {
        ob_start();
        ?>
        <p>Votre demande de transfers d'agence est actuellement <strong>terminer</strong>.</p>
        <p>Votre nouveau conseiller est: <strong><?= $this->transferAgency->customer->agent->full_name ?></strong></p>
        <?php
        return ob_get_clean();
    }

    private function failed()
    {
        ob_start();
        ?>
        <p>Votre demande de transfers d'agence à été <strong>refuser</strong>.</p>
        <p>Veuillez contacter votre conseiller clientèle afin d'en connaître la raison.</p>
        <?php
        return ob_get_clean();
    }
}
