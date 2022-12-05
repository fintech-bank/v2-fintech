<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Core\Bank;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerMobility;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewMobilityNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;
    private CustomerMobility $mobility;

    /**
     * @param Customer $customer
     * @param CustomerMobility $mobility
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerMobility $mobility, string $category)
    {
        $this->customer = $customer;
        $this->mobility = $mobility;
        $this->title = "Demande de transfert Bancaire - Transbank {$this->mobility->ref_mandate}";
        $this->message = $this->getMessage();
        $this->link = route('customer.account.profil.mobility.index');
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p class="fw-bolder">Merci d'utiliser Transbank</p>
        <p>Une demande de transfert bancaire a été effectuer ce jour, voici un récapitulatif de votre demande:</p>
        <table class="table table-sm table-striped">
            <tbody>
                <tr>
                    <td class="fw-bolder">Nom du mandat</td>
                    <td><?= $this->mobility->name_mandate ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Référence du mandat</td>
                    <td><?= $this->mobility->ref_mandate ?></td>
                </tr>
                <tr>
                    <td class="fw-bolder">Ancien compte</td>
                    <td>
                        <strong><?= $this->mobility->name_account ?></strong><br>
                        <strong>IBAN:</strong> <?= $this->mobility->iban ?><br>
                        <strong>BIC:</strong> <?= $this->mobility->bic ?><br>
                        <strong>Banque:</strong> <?= Bank::getBankByBic($this->mobility->bic) ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bolder">Nouveau compte</td>
                    <td><?= $this->mobility->wallet->name_account_generic ?></td>
                </tr>
                <?php if($this->mobility->date_transfer != null): ?>
                <tr>
                    <td class="fw-bolder">Date de transfers</td>
                    <td><?= $this->mobility->date_transfer->format('d/m/Y') ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td class="fw-bolder">Cloture de l'ancien compte</td>
                    <td><?= $this->mobility->cloture ? "Oui" : "Non" ?></td>
                </tr>
            </tbody>
        </table>
        <p>Toutes ces informations vont être transmise à la banque distante et une demande de listing de mouvement va lui être transmise.</p>
        <?php if($this->mobility->type->select_mvm): ?>
        <p>Une fois cette liste réceptionner chez nous, vous aurez la possibilité de sélectionner les mouvements que vous souhaiter ramener chez nous.</p>
        <?php else: ?>
        <p>Une fois cette liste réceptionner chez nous, les mouvements seront automatiquement instruits sur le compte choisi lors de l'établissement du mandat.</p>
        <?php endif; ?>
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
        $message->view("emails.customer.new_mobility", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Vos mandats de mobilité bancaire";
        $message->actionUrl = $this->link;

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-arrow-right-arrow-left",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->mobility]
        ];
    }
}
