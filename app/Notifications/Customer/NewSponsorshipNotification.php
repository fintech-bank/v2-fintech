<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Core\Sponsorship;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewSponsorshipNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;
    private Sponsorship $sponsorship;

    /**
     * @param Customer $customer
     * @param Sponsorship $sponsorship
     * @param string $category
     */
    public function __construct(Customer $customer, Sponsorship $sponsorship, string $category)
    {
        $this->customer = $customer;
        $this->sponsorship = $sponsorship;
        $this->title = "Nouveau Parrainage";
        $this->message = $this->getMessage();
        $this->link = route('customer.account.profil.sponsorship.index');
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Vous venez d'indiquer un nouveau filleul sur votre espace client.<br>Voici les conditions de l'offre parrainage en vigueur actuellement.</p>
        <ol>
            <li>Votre filleul va recevoir un email l'invitant à ouvrir un compte en ligne ou en agence avec un code de parrainage.</li>
            <li>Vous et votre filleul recevrez votre prime 1 semaine maximum après validation de l'ouverture de compte (80 €)</li>
        </ol>
        <p>Voici les informations renseignées:</p>
        <table class="table table-sm">
            <tbody>
            <tr>
                <td class="fw-bolder">Civilité</td>
                <td><?= $this->sponsorship->civility ?></td>
            </tr>
                <tr>
                    <td class="fw-bolder">Nom de famille</td>
                    <td><?= $this->sponsorship->lastname ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Prénom</td>
                    <td><?= $this->sponsorship->firstname ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Localité</td>
                    <td><?= $this->sponsorship->postal ?> <?= $this->sponsorship->city ?></td>
                </tr>
            </tbody>
        </table>
        <p>Un email vous sera envoyer lorsque votre filleul aura complété son ouverture de compte.</p>
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
        $message->view("emails.customer.new_sponsorship", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Suivre mes parrainages";
        $message->actionUrl = $this->link;
        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-hand-holding-heart",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->sponsorship]
        ];
    }
}
