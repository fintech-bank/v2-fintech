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

class GrpdUpdateDroitAcceNotification extends Notification
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
        $this->title = "Information sur votre demande de droit d'accès";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <?php if($this->demande->status == 'terminated'): ?>
        <p>Votre requête de droit d'accès a été traités et est disponible dans votre espace client.</p>
        <?php elseif ($this->demande->status == 'cancel'): ?>
        <p>Votre requête de droit d'accès a été annulée.</p>
        <?php else: ?>
        <p>Votre requête de droit d'accès a été rejeté par notre service financier.<br>Si vous souhaitez plus d'informations concernant ce rejet, veuillez contacter votre conseiller.</p>
        <?php endif; ?>
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
        $message->view("emails.customer.grpd_update_droit_acce", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-user-shield",
            "color" => "",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer]
        ];
    }
}
