<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCheck;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class UpdateCheckoutCheckNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerCheck $check;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerCheck $check
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerCheck $check, string $category)
    {
        $this->customer = $customer;
        $this->check = $check;
        $this->title = "Information sur votre chéquier N°{$this->check->reference}";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="d-flex flex-row justify-content-between w-100">
            <div class="d-flex flex-column text-center">
                <i class="fa-solid fa-cogs fs-3tx"></i>
                <div class="fw-bolder">Création en cours</div>
                <div class="text-muted">Votre chéquier est actuellement en cours de création</div>
            </div>
            <div class="d-flex flex-column text-center">
                <i class="fa-solid fa-truck-fast fs-3tx"></i>
                <div class="fw-bolder">Envoie en cours</div>
                <div class="text-muted">Votre chéquier est actuellement en cours d'expédition</div>
            </div>
            <div class="d-flex flex-column text-center">
                <i class="fa-solid fa-building fs-3tx"></i>
                <div class="fw-bolder">Dans votre agence</div>
                <div class="text-muted">Votre chéquier est actuellement en agence</div>
            </div>
            <div class="d-flex flex-column text-center">
                <i class="fa-solid fa-check-circle fs-3tx"></i>
                <div class="fw-bolder">Terminé</div>
                <div class="text-muted">D'après nos systèmes, votre chéquier est terminé</div>
            </div>
            <div class="d-flex flex-column text-center">
                <i class="fa-solid fa-cogs fs-3tx"></i>
                <div class="fw-bolder">Chéquier Détruit</div>
                <div class="text-muted">D'après nos systèmes, votre chéquier à été détruit</div>
            </div>
        </div>
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
        $message->view("emails.customer.update_checkout_check", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => $this->check->getStatus(),
            "color" => $this->check->getStatus('color'),
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->check]
        ];
    }
}
