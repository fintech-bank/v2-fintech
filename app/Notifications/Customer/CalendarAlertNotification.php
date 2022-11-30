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
        <p>Nous vous remercions d'avoir pris contact avec nous. Nous avons le plaisir de vous confirmer votre rendez-vous avec <?= $this->event->agent->name ?> pour échanger sur le motif suivant : <?= $this->event->subreason ?>.</p>
        <p>Votre rendez-vous se tiendra :</p>
        <ul>
            <li>Le <strong><?= formatDateFrench($this->event->start_at, true) ?></strong> pour une durée estimée à <strong><?= $this->event->start_at->diffForHumans($this->event->end_at) ?></strong></li>
            <li><strong><?= $this->event->getCanal('text') ?></strong>:
            <?php if($this->event->canal == 'phone'): ?>
            vous serez contacté par le conseiller au <strong><?= $this->customer->info->getMobileNumber('obscure') ?></strong>
            <?php elseif ($this->event->canal == 'agency'): ?>
            à l'adresse: <strong><?= $this->customer->agency->address_line ?></strong>
            <?php else: ?>
            <?= $this->event->lieu; ?>
            <?php endif; ?>
            </li>
        </ul>
        <p>Afin de s'adapter à la situation ou votre projet, le conseiller est susceptible de vous demander des documents complémentaires.</p>
        <p>En cas d'indisponibilité, vous pouvez annuler votre rendez-vous en ligne depuis votre espace client.</p>
        <?php
        return ob_get_clean();
    }

    private function getMessagePhone()
    {
        ob_start();
        ?>
        Nous avons le plaisir de vous confirmer votre rendez-vous avec <?= $this->event->agent->name ?><br />
        Le rendez-vous se tiendra le <?= formatDateFrench($this->event->start_at, true) ?> <?= \Str::lower($this->event->getCanal('text')) ?>
        <?php
        return ob_get_clean();
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_sms) {
                return [FreeMobileChannel::class, 'database'];
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
        $message->view("emails.customer.calendar_alert", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-calendar",
            "color" => "primary",
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
