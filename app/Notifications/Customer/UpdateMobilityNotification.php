<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerMobility;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class UpdateMobilityNotification extends Notification
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
        $this->title = "Transbank - Mandat {$this->mobility->ref_mandate}";
        $this->message = $this->getMessage();
        $this->link = route('customer.account.profil.mobility.index');
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p class="fw-bolder">Votre procédure de transfert bancaire <?= $this->mobility->ref_mandate ?></p>
        <?php
        match ($this->mobility->status) {
            "select_mvm_bank" => $this->selectMvmBank(),
            'bank_end' => $this->bankEnd(),
            "creditor_start" => $this->creditorStart(),
            "select_mvm_creditor" => $this->selectMvmCredit(),
            "creditor_end" => $this->creditorEnd(),
            "terminated" => $this->terminated(),
            "error" => $this->error()
        };
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
        $message->view("emails.customer.update_mobility", [
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
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->mobility]
        ];
    }

    private function selectMvmBank()
    {
        ob_start();
        ?>
        <p>Votre ancienne banque nous a transmis l'ensemble des mouvements récurrent de votre ancien compte.</p>
        <p>Vous devez sélectionner les mouvements que vous souhaitez rapatrier sur votre nouveau compte afin de terminer la procédure bancaire.</p>
        <?php
        return ob_get_clean();
    }

    private function bankEnd()
    {
        ob_start();
        ?>
        <p>Les mouvements relatifs à votre ancien compte ont été rapatrier avec succès sur votre nouveau compte.</p>
        <?php
        return ob_get_clean();
    }

    private function creditorStart()
    {
        ob_start();
        ?>
        <p>Si sur votre ancien compte, des organismes ont été provisionner, nous allons maintenant les interrogés et importé leurs mandats de virement ou de prélèvement.</p>
        <?php
        return ob_get_clean();
    }

    private function selectMvmCredit()
    {
        ob_start();
        ?>
        <p>Certains organisme nous ont transmis leur mandat.</p>
        <p>Vous devez sélectionner les mouvements que vous souhaitez rapatrier sur votre nouveau compte afin de terminer la procédure d'importation d'organisme.</p>
        <?php
        return ob_get_clean();
    }

    private function creditorEnd()
    {
        ob_start();
        ?>
        <p>L'ensemble des mandats des organismes sélectionner ont été importé dans votre compte bancaire.</p>
        <?php
        return ob_get_clean();
    }

    private function terminated()
    {
        ob_start();
        ?>
        <p>Le Transfert Bancaire <?= $this->mobility->ref_mandate ?> est à présent terminer.</p>
        <?php
        return ob_get_clean();
    }

    private function error()
    {
        ob_start();
        ?>
        <p>Une erreur à eu lieu lors de la procédure de transfert bancaire.<br>Veuillez contacter votre conseiller au plus vite !</p>
        <?php
        return ob_get_clean();
    }
}
