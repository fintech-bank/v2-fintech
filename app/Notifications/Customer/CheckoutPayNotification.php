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

class CheckoutPayNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public string $messagePhone;
    public Customer $customer;
    private CustomerSepa $sepa;
    private string $linkCheckout;

    /**
     * @param Customer $customer
     * @param CustomerSepa $sepa
     * @param string $linkCheckout
     */
    public function __construct(Customer $customer, CustomerSepa $sepa, string $linkCheckout)
    {
        $this->customer = $customer;
        $this->sepa = $sepa;
        $this->linkCheckout = $linkCheckout;
        $this->title = "Nouvelle demande de paiement";
        $this->message = $this->getMessage();
        $this->messagePhone = $this->getMessagePhone();
        $this->link = $linkCheckout;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Voici un lien pour régler votre retard de paiement d'un montant de <span class="fw-bolder text-danger"><?= $this->sepa->amount_format ?></span></p>
        <?php
        return ob_get_clean();
    }

    private function getMessagePhone()
    {
        ob_start();
        ?>
        <p>Veuillez suivre le lien suivant afin de régler votre retard de paiement de <?= $this->sepa->amount_format ?>: <?= $this->link ?></p>
        <?php
        return ob_get_clean();
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
        $message->view("emails.customer.checkout_pay", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = 'Payer la somme de '.$this->sepa->amount_format;
        $message->actionUrl = $this->link;

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-euro",
            "color" => "danger",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }

    public function toFreeMobile($notifiable)
    {
        $message = (new FreeMobileMessage());
        $message->message(strip_tags($this->messagePhone));

        return $message;
    }

    public function toTwilio($notifiable)
    {
        $message = (new TwilioSmsMessage());
        $message->content(strip_tags($this->messagePhone));

        return $message;
    }
}
