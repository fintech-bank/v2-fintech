<?php
namespace App\Notifications\Customer\Sending;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendVerifyAddressCustomerLinkNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public string $messagePhone;
    public Customer $customer;
    public string $category;

    public function __construct(Customer $customer, string $category)
    {
        $this->customer = $customer;
        $this->title = "Vérifier votre adresse postal";
        $this->message = $this->getMessage();
        $this->messagePhone = $this->getMessagePhone();
        $this->link = route('verify-address', ['token' => encrypt($customer->user->email)]);
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>
            Notre système nous indique que votre adresse postal n'a pas été vérifié.<br>
            Nous ne pouvons correspondre avec vous si cette adresse reste invalide ou non vérifier.
        </p>
        <p>Afin d'effectuer cette vérification, veuillez cliquer sur le bouton ci-dessous.</p>
        <?php
        return ob_get_clean();
    }

    private function getMessagePhone()
    {
        ob_start();
        ?>
        Votre adresse postal n'a pas été vérifier, veuillez vérifier vos mails afin vérifier votre adresse d'habitation.
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
        $message->view("emails.customer.send_verify_address_customer_link", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionUrl = $this->link;
        $message->actionText = "Vérifier mon adresse";

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-building-shield",
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer]
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
