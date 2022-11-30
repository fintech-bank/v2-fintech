<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class OppositTransactionNotification extends Notification
{

    public Customer $customer;
    public CustomerTransaction $transaction;
    public string $raison;
    public string $title;
    public string $link;
    public string $message;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerTransaction $transaction
     * @param string $raison
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerTransaction $transaction, string $raison, string $category)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
        $this->raison = $raison;
        $this->title = "Opposition sur un mouvement bancaire";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="fw-bolder fs-2 mb-2">Opposition sur un mouvement bancaire</div>
        <p>Une transaction d'un montant de <strong><?= $this->transaction->amount_format ?></strong> à fait l'objet d'une opposition par notre service financier en date du <strong><?= $this->transaction->updated_at->format('d/m/Y') ?></strong>.</p>
        <p>Aucun frais supplémentaire ne vous sera prélevé.</p>
        <p>La raison évoquer pour cette opposition est : <strong><?= $this->raison ?></strong></p>
        <p>Pour contester cette opposition, veuillez contacter votre conseiller bancaire.</p>
        <?php
        return ob_get_clean();
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_sms) {
                return [FreeMobileChannel::class, "database"];
            }

            if($this->customer->setting->notif_mail) {
                return ["mail", "database"];
            }

            return "database";
        } else {

            if($this->customer->setting->notif_sms) {
                return [TwilioChannel::class, "database"];
            }

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
        $message->view("emails.customer.opposit_transaction", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-ban",
            "color" => "danger",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->transaction, $this->raison]
        ];
    }

    public function toFreeMobile($notifiable)
    {
        $message = (new FreeMobileMessage());
        $message->message(strip_tags($this->message));

        return $message;
    }

    public function toTwilio($notifiable)
    {
        $message = (new TwilioSmsMessage());
        $message->content(strip_tags($this->message));

        return $message;
    }
}
