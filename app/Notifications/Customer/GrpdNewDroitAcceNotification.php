<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerGrpdDemande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class GrpdNewDroitAcceNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;
    private CustomerGrpdDemande $demande;

    /**
     * @param Customer $customer
     * @param CustomerGrpdDemande $demande
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerGrpdDemande $demande, string $category)
    {
        $this->customer = $customer;
        $this->demande = $demande;
        $this->title = "Nouvelle demande de droit d'accès";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Vous avez récemment effectuer une demande de droit d'accès à vos fichiers personnel, la requête nous à été transmise et sera traité dans les meilleurs délais.</p>
        <p>Voici un récapitulatif de votre demande:</p>
        <ul>
            <li><strong>Type de requête:</strong> <?= $this->demande->type_text ?></li>
            <li><strong>Sujet:</strong> <?= $this->demande->object ?></li>
            <li><strong>Description:</strong> <?= $this->demande->comment ?></li>
        </ul>
        <?php
        return ob_get_clean();
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
        $message->view("emails.customer.grpd_new_droit_acce", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-user-shield",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->demande]
        ];
    }
}
