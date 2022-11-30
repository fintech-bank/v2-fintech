<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class CancelCreditCardNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public string $messagePhone;
    public Customer $customer;
    private CustomerCreditCard $card;
    public string $category;

    /**
     * @param Customer $customer
     * @param CustomerCreditCard $card
     */
    public function __construct(Customer $customer, CustomerCreditCard $card, string $category)
    {
        $this->customer = $customer;
        $this->card = $card;
        $this->title = "Annulation de votre carte bancaire {$card->number_card_oscure}";
        $this->message = $this->getMessage();
        $this->messagePhone = $this->getMessagePhone();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Votre carte bancaire <strong><?= $this->card->number_card_oscure ?></strong> à été annulé par notre service financier.</p>
        <p>Veuillez convenir d'un rendez-vous avec votre conseiller afin de restituer cette carte pour destruction.</p>
        <?php
        return ob_get_clean();
    }

    private function getMessagePhone()
    {
        ob_start();
        ?>
        Votre carte bancaire <?= $this->card->number_card_oscure ?> à été annulé par notre service financier.
        <?php
        return ob_get_clean();
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_sms) {
                return [FreeMobileChannel::class, "database"];
            }

            if($this->customer->setting->notif_mail) {
                return ["mail", "database"];
            }

            return "database";
        } else {

            if($this->customer->setting->notif_sms) {
                return [TwilioChannel::class, "database"];
            }

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
        $message->view("emails.customer.cancel_credit_card", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-credit-card",
            "color" => "danger",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->card]
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
