<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransferAgency;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewTransferAgencyNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;
    private CustomerTransferAgency $transferAgency;

    /**
     * @param Customer $customer
     * @param CustomerTransferAgency $transferAgency
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerTransferAgency $transferAgency, string $category)
    {
        $this->customer = $customer;
        $this->transferAgency = $transferAgency;
        $this->title = "Votre demande de transfert d'agence";
        $this->message = $this->getMessage();
        $this->link = route('customer.account.profil.transfer.index');
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Vous venez d'effectuer une demande de transfert d'agence.<br>Voici un récapitulatif de votre demande:</p>
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td class="fw-bolder">Référence</td>
                    <td><?= $this->transferAgency->reference ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Agence de départ</td>
                    <td>
                        <strong><?= $this->transferAgency->customer->agency->name ?></strong><br>
                        <?= $this->transferAgency->customer->agency->address ?><br>
                        <?= $this->transferAgency->customer->agency->postal ?> <?= $this->transferAgency->customer->agency->city ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bolder">Agence d'arriver</td>
                    <td>
                        <strong><?= $this->transferAgency->agency->name ?></strong><br>
                        <?= $this->transferAgency->agency->address ?><br>
                        <?= $this->transferAgency->agency->postal ?> <?= $this->transferAgency->agency->city ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bolder">Comptes individuels et services</td>
                    <td><?= $this->transferAgency->transfer_account ? 'Oui' : 'Non' ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Comptes Joints et services</td>
                    <td><?= $this->transferAgency->transfer_joint ? 'Oui' : 'Non' ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Ensembles de comptes et services</td>
                    <td><?= $this->transferAgency->transfer_all ? 'Oui' : 'Non' ?></td>
                </tr>
            </tbody>
        </table>
        <p>Vous serez alerté par mail lorsque votre dossier sera mis à jours.</p>
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
        $message->view("emails.customer.new_transfer_agency", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Suivre mes transfert d'agence";
        $message->actionUrl = route('customer.account.profil.transfer.index');

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-building",
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->transferAgency]
        ];
    }
}
