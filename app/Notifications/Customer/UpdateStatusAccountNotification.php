<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class UpdateStatusAccountNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;
    private ?string $raison;

    /**
     * @param Customer $customer
     * @param string $category
     * @param string|null $raison
     */
    public function __construct(Customer $customer, string $category, string $raison = null)
    {
        $this->customer = $customer;
        $this->title = "Votre compte en ligne";
        $this->raison = $raison;
        $this->category = $category;
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        return match ($this->customer->status_open_account) {
            "completed" => $this->onCompleted(),
            "accepted" => $this->onAccepted($this->customer),
            "declined" => $this->onDeclined(),
            "terminated" => $this->onTerminated(),
            "suspended" => $this->onSuspended(),
            "closed" => $this->onClosed()
        };
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
        $message->view("emails.customer.update_status_account", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-wallet",
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->raison]
        ];
    }

    private function onCompleted()
    {
        ob_start();
        ?>
        <p>
            Votre dossier d'ouverture de compte bancaire est actuellement terminé.<br>
            Un conseiller bancaire va étudier votre dossier et un mail vous sera envoyer avec l'acceptation ou le refus de votre demande d'ouverture de compte chez nous!
        </p>
        <p>Si vous n'êtes pas à l'origine de cette demande, merci de nous contacter au plus vite !</p>
        <?php
        return ob_get_clean();
    }
    private function onAccepted(Customer $customer)
    {
        ob_start();
        ?>
        <p>Votre dossier d'ouverture de compte à été <strong>ACCEPTER</strong> par notre service financier.</p>
        <p>Votre conseiller est <?= $customer->agent->name ?>>.<br>Vous pouvez le contacter si vous avez des questions relatives à la gestion de votre compte client.</p>
        <p>Toutes l'équipe de <?= config('app.name') ?> vous souhaitent la bienvenue parmis nous !</p>
        <?php
        return ob_get_clean();
    }
    private function onDeclined()
    {
        ob_start();
        ?>
        <p>Votre dossier d'ouverture de compte à été <strong>REFUSER</strong> par notre service financier.</p>
        <p>Nous sommes désolé de ne pouvoir donner suite à votre demande.</p>
        <?php
        return ob_get_clean();
    }
    private function onTerminated()
    {
        ob_start();
        ?>
        <p>Votre compte personnel est maintenant OUVERT.</p>
        <p>Vous pouvez y acceder directement par l'intermédiaire de votre espace client avec les identifiants et mot de passe qui vous ont été transmis dans un email à part !</p>
        <?php
        return ob_get_clean();
    }
    private function onSuspended()
    {
        ob_start();
        ?>
        <p>Votre compte client à été <strong>SUSPENDU</strong> par notre service compte bancaire.</p>
        <p>La raison évoquée est la suivante:</p>
        <blockquote><?= $this->raison ?></blockquote>
        <p>Si vous avez des questions relatives à cette raison, n'hésitez pas à contacter votre conseiller.</p>
        <?php
        return ob_get_clean();
    }
    private function onClosed()
    {
        ob_start();
        ?>
        <p>Votre compte client à été <strong>CLOTÛRER</strong> par notre service compte bancaire.</p>
        <p>La Raison évoquée est la suivante:</p>
        <blockquote><?= $this->raison ?></blockquote>
        <p>Une lettre recommandée vous a été envoyer ce jour.</p>
        <p>Si vous avez des questions relatives à cette raison, n'hésitez pas à contacter votre conseiller.</p>
        <?php
        return ob_get_clean();
    }
}
