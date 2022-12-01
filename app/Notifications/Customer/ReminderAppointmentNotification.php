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

class ReminderAppointmentNotification extends Notification
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
        $this->title = "Rappel de votre rendez-vous";
        $this->message = $this->getMessage();
        $this->messagePhone = $this->getMessagePhone();
        $this->link = route('customer.account.agenda.show', $event->id);
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="fw-bolder">Rappel de votre rendez-vous</div>
        <?php if($this->event->canal == 'agency'): ?>
        <p>Nous vous rappelons que vous avez un rendez-vous en agence le <strong><?= formatDateFrench($this->event->start_at) ?></strong> avec <strong><?= $this->event->agent->full_name ?></strong>.</p>
        <?php else: ?>
        <p>Nous vous rappelons que vous avez un rendez-vous par téléphone le <strong><?= formatDateFrench($this->event->start_at) ?></strong> avec <strong><?= $this->event->agent->full_name ?></strong>.</p>
        <?php endif; ?>
        <p>N'oubliez pas de vous munir des documents nécessaires.</p>
        <?php
        return ob_get_clean();
    }

    private function getMessagePhone()
    {
        ob_start();
        ?>
        <?php if($this->event->canal == 'agency'): ?>
        <p>Nous vous rappelons que vous avez un rendez-vous en agence le <strong><?= formatDateFrench($this->event->start_at) ?></strong> avec <strong><?= $this->event->agent->full_name ?></strong>.</p>
        <?php else: ?>
            <p>Nous vous rappelons que vous avez un rendez-vous par téléphone le <strong><?= formatDateFrench($this->event->start_at) ?></strong> avec <strong><?= $this->event->agent->full_name ?></strong>.</p>
        <?php endif; ?>
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
        $message->view("emails.customer.reminder_appointment", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-bell",
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->event]
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
