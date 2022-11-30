<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Core\Event;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class CalendarAlertNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public string $messagePhone;
    public Customer $customer;
    public string $category;
    private Event $event;

    /**
     * @param Customer $customer
     * @param Event $event
     * @param string $category
     */
    public function __construct(Customer $customer, Event $event, string $category)
    {
        $this->customer = $customer;
        $this->event = $event;
        $this->title = "Confirmation de votre rendez-vous";
        $this->message = $this->getMessage();
        $this->messagePhone = $this->getMessagePhone();
        $this->link = route('customer.account.agenda.show', );
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="fw-bolder fs-2">Confirmation de votre rendez-vous</div>
        <p>Nous vous remercions d'avoir pris contact avec nous. Nous avons le plaisir de vous confirmer votre rendez-vous avec  pour échanger sur le motif suivant : Avoir des informations sur un découvert.</p>
        <?php
        return ob_get_clean();
    }

    private function getMessagePhone()
    {
        ob_start();
        ?>

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
        $message->view("emails.customer.calendar_alert", [
            "content" => $this->message,
            "customer" => $this->customer
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
