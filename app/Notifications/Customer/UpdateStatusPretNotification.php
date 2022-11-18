<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class UpdateStatusPretNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerPret $pret;

    public function __construct(Customer $customer, CustomerPret $pret)
    {
        $this->customer = $customer;
        $this->pret = $pret;
        $this->title = "Votre {$pret->plan->name} N° {$pret->reference}";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Votre <?= $this->pret->plan->name ?> est maintenant indiqué comme : <strong><?= $this->pret->getStatus('text') ?></strong></p>
        <?php if($this->pret->status == 'study'): ?>
        <p>Notre équipe financière va maintenant procéder à quelque vérification afin de décider quelle suite donner à votre dossier.</p>
        <p>Pendant ce temps, certaines informations peuvent vous être demandées par l'intermédiaire de votre espace client.</p>
        <?php elseif ($this->pret->status == 'accepted'): ?>
        <p>Suivant le type de crédit que vous avez souscrit, le montant demandé peut vous être libéré sous 8 jours calendaire à compté de la prise de décision.</p>
        <?php elseif ($this->pret->status == 'refused'): ?>
        <p>Malheureusement, nous ne pouvons donner suite à votre demande.</p>
        <p>N'hésitez pas à nous consulter dans quelque temps, ou si votre situation venait à évolué.</p>
        <?php elseif ($this->pret->status == 'progress'): ?>
        <p>Le montant de votre crédit (<?= $this->pret->amount_loan_format ?>) est maintenant disponible.</p>
        <?php elseif ($this->pret->status == 'terminated'): ?>
        <p>Nous vous remercions d'avoir fait appel à nos services et n'hésitez pas à nous solicités si vous avez besoins d'un nouveau financement.</p>
        <?php else: ?>
        <p>Une erreur a été détecté concernant votre crédit.<br>Veuillez contacter votre conseiller bancaire pour en savoir plus.</p>
        <?php endif; ?>
        <?php
        return ob_get_clean();
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        } else {
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
        $message->view("emails.customer.update_status_pret", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-hand",
            "color" => $this->pret->getStatus('color'),
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
