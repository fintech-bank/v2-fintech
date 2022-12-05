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
                        <strong>Banque:</strong>
                    </td>
                </tr>
            </tbody>
        </table>
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

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "",
            "color" => "",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer]
        ];
    }
}
