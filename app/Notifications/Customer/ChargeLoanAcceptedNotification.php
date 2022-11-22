<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ChargeLoanAcceptedNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public CustomerPret $pret;
    public Customer $customer;

    /**
     * @param Customer $customer
     * @param CustomerPret $pret
     */
    public function __construct(Customer $customer, CustomerPret $pret)
    {
        $this->customer = $customer;
        $this->pret = $pret;
        $this->title = "Information sur votre pret personnel N°".$this->pret->reference;
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        $message = "Le montant de votre prêt personnel N°".$this->pret->reference." est maintenant disponible.<br>";
        $message .= "Voici un récapitulatif de l'opération:";
        ob_start();
        ?>
        <ul>
            <li>Prêt N°<?= $this->pret->reference ?></li>
            <li>Montant Disponible: <?= $this->pret->amount_loan ?></li>
            <li>Souscrit le: <?= $this->pret->created_at->format('d/m/Y') ?></li>
            <li>Libéré le: <?= $this->pret->updated_at->format("d/m/Y à H:i") ?></li>
        </ul>
        <?php
        $message .= ob_get_clean();
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
        $message->subject($this->title);
        $message->view('emails.customer.charge_loan_accepted', [
            'content' => $this->message,
            'customer' => $this->customer,
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "",
            "color" => "",
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
