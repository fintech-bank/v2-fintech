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

class GrpdPortabilityDocNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;

    public function __construct(Customer $customer, string $category)
    {
        $this->customer = $customer;
        $this->title = "Nouveau document de portabilité";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Vous avez récemment demander à avoir accès par portabilité à vos données utilisateurs.</p>
        <p>Veuillez trouver ci-joint, l'ensemble des documents relatifs à vos données personnelles.</p>
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
        $message->view("emails.customer.grpd_portability_doc", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->attach(public_path('/uploads/portability/Document-CUS'.$this->customer->user->identifiant.'.pdf'));

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
            "category" => $this->category,
            "models" => [$this->customer]
        ];
    }
}
