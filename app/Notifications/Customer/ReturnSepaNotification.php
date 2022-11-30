<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerSepa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ReturnSepaNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerSepa $sepa;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerSepa $sepa
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerSepa $sepa, string $category)
    {
        $this->customer = $customer;
        $this->sepa = $sepa;
        $this->title = "Votre prélèvement bancaire à été retourné";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Nos système nous indique que votre prélèvement <strong><?= $this->sepa->number_mandate ?></strong> d'un montant de <strong><?= $this->sepa->amount_format ?></strong> pour <strong><?= $this->sepa->creditor ?></strong> à été retourné par la banque distante.</p>
        <p>Le montant n'a donc pas été débité de votre compte et aucun frais n'ont été prélevé.</p>
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
        $message->view("emails.customer.return_sepa", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-rotate-left",
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->sepa]
        ];
    }
}
