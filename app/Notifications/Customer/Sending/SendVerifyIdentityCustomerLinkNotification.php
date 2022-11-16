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

class SendVerifyIdentityCustomerLinkNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public string $messagePhone;
    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->title = "Vérifier votre identité";
        $this->message = $this->getMessage();
        $this->messagePhone = $this->getMessagePhone();
        $this->link = route('verify-identity', ["token" => encrypt($customer->user->email)]);
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>
            Notre système nous indique que votre identité n'a pas été vérifié.<br>
            Certaine fonction nécessite que votre identité soit vérifier afin d'éviter l'usurpation de votre identité.
        </p>
        <p>Afin d'effectuer cette vérification, veuillez cliquer sur le bouton ci-dessous.</p>
        <?php
        return ob_get_clean();
    }

    private function getMessagePhone()
    {
        ob_start();
        ?>
        Votre identité n'a pas été vérifier, veuillez vérifier vos mails afin vérifier votre identité.
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
        $message->view("emails.customer.send_verify_identity_customer_link", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Vérifier mon identité";
        $message->actionUrl = $this->link;

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-user-shield",
            "color" => "info",
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
