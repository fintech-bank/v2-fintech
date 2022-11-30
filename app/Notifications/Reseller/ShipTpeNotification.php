<?php
namespace App\Notifications\Reseller;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Core\Shipping;
use App\Models\Customer\Customer;
use App\Models\Reseller\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ShipTpeNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    private Reseller $reseller;
    private Shipping $shipping;
    private string $category;

    /**
     * @param Reseller $reseller
     * @param Shipping $shipping
     * @param string $category
     */
    public function __construct(Reseller $reseller, Shipping $shipping, string $category)
    {
        $this->reseller = $reseller;
        $this->shipping = $shipping;
        $this->title = "Notification d'envoie FINTECH, numéro de suivi ".$this->shipping->number_ship;
        $this->message = $this->getMessage();
        $this->link = "https://tracker.fintech.ovh/ship?suivi=".$this->shipping->number_ship;
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="fw-bolder fs-3 mb-3">Un Colis vous à été envoyé</div>
        <img src="<?= config('app.url') ?>/assets/media/illustrations/dozzy-1/20.png" class="mb-3"/>
        <p>Ce message vous a été envoyé à la demande de <?= config('app.name') ?> il vous avertit que les informations ci-dessous relatives à l’expédition ont été transmises à FINTECH Transport par voie électronique.</p>
        <p>Votre TPE Distributeur a ete envoyée via un colis FINTECH Transport. Vous trouverez toutes les references pour le suivi de cet envoi ci-dessous.</p>
        <div class="my-5"></div>
        <div class="fw-bolder">Détail concernant l'envoi</div>
        <div class="separator my-2"></div>
        <table width="100">
            <tbody>
                <tr>
                    <td>DE</td>
                    <td class="text-end"><?= config('app.name') ?></td>
                </tr>
                <tr>
                    <td>Numéro de suivi</td>
                    <td class="text-end"><a href="<?= $this->link ?>"><?= $this->shipping->number_ship ?></a></td>
                </tr>
                <tr>
                    <td>Expédier vers</td>
                    <td class="text-end">
                        <?= $this->reseller->dab->address_format ?>
                    </td>
                </tr>
                <tr>
                    <td>Livraison programmée</td>
                    <td class="text-end"><?= config('app.name') ?></td>
                </tr>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }

    private function choiceChannel()
    {
        return ["mail", "database"];
    }

    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage);
        $message->subject($this->title);
        $message->view("emails.reseller.ship_tpe", [
            "content" => $this->message,
            "reseller" => $this->reseller
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-truck-fast",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->reseller, $this->shipping]
        ];
    }
}
