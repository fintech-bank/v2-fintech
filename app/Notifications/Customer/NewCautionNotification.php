<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPretCaution;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewCautionNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerPretCaution $caution;

    /**
     * @param Customer $customer
     * @param CustomerPretCaution $caution
     */
    public function __construct(Customer $customer, CustomerPretCaution $caution)
    {
        $this->customer = $customer;
        $this->caution = $caution;
        $this->title = "Cautionnement du ".$this->caution->loan->wallet->name_account_generic;
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Afin de sécurisée votre <?= $this->caution->loan->wallet->name_account_generic ?> un cautionnaire c'est porté garant<br>Voici les informations relatives à ce cautionnaire:</p>
        <table class="table-border table-sm">
            <tbody>
                <tr>
                    <td class="fw-bolder">Type de caution</td>
                    <td><?= $this->caution->getTypeCaution('text') ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Type de cautionnaire</td>
                    <td><?= $this->caution->getType('text') ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Identité</td>
                    <td>
                        <?php if($this->caution->type == 'physique'): ?>
                            <?= $this->caution->civility; ?> <?= $this->caution->firstname; ?> <?= $this->caution->lastname; ?><br>
                            <?= $this->caution->num_cni; ?>
                        <?php else: ?>
                            <?= $this->caution->company; ?><br>
                            <?= $this->caution->siret; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php if(!$this->caution->sign_caution): ?>
        <p>Le cautionnaire doit maintenant signer l'acte de cautionnement qui lui à soit été envoyé par mail ou s'il a accès à FICAP, disponible sur son espace.</p>
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
        $message->view("emails.customer.new_caution", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-file-signature",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
