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

class NewAppointmentNotification extends Notification
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
        $this->title = "Votre rendez-vous avec votre conseiller";
        $this->message = $this->getMessage();
        $this->link = route('customer.account.agenda.show', $event->id);
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="fw-bolder">Confirmation de votre rendez-vous</div>
        <p>Nous vous remercions d'avoir pris contact avec nous. Nous avons le plaisir de vous confirmer votre rendez-vous avec <?= $this->event->agent->full_name ?> pour échanger sur le motif suivant : <strong><?= $this->event->subreason ?></strong>.</p>
        <p>Votre rendez-vous se tiendra:</p>
        <ul>
            <li>Le <strong><?= formatDateFrench($this->event->start_at) ?></strong> pour une durée estimée à <strong><?= $this->event->start_at->longAbsoluteDiffForHumans($this->event->end_at) ?></strong></li>
            <?php if($this->event->canal == 'phone'): ?>
            <li><strong><?= $this->event->getCanal('text') ?>:</strong> vous serez contacté par le conseiller au <strong><?= $this->event->user->customers->info->getMobileNumber('obscure') ?></strong></li>
            <?php else: ?>
            <li><?= $this->event->getCanal('text') ?>:</strong> votre rendez-vous aura lieu à l'agence <strong><?= $this->event->agent->agency->name ?></strong></li>
            <?php endif; ?>
        </ul>
        <p>Afin de s'adapter à la situation ou votre projet, le conseiller est susceptible de vous demander des documents complémentaires.</p>
        <p>En cas d'indisponibilité, vous pouvez annuler votre rendez-vous en ligne depuis votre espace client.</p>
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
        $message->view("emails.customer.new_appointment", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-calendar",
            "color" => "success",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->event]
        ];
    }
}
