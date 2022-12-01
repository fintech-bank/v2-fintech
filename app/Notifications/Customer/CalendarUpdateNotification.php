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

class CalendarUpdateNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
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
        $this->title = "Mise à jours des informations sur votre rendez-vous";
        $this->message = $this->getMessage();
        $this->link = route('customer.account.agenda.show', $event->id);
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p class="fw-bolder"><?= $this->title ?></p>
        <p>De nouvelles informations ont été ajoutées concernant votre rendez-vous.</p>
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
        $message->view("emails.customer.calendar_update", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-calendar-check",
            "color" => "warning",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->event]
        ];
    }
}
