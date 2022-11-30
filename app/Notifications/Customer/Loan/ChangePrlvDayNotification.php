<?php
namespace App\Notifications\Customer\Loan;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ChangePrlvDayNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerPret $credit;
    public string $category;

    /**
     * @param Customer $customer
     * @param CustomerPret $credit
     */
    public function __construct(Customer $customer, CustomerPret $credit, string $category)
    {
        $this->customer = $customer;
        $this->credit = $credit;
        $this->title = "Information sur le {$this->credit->wallet->name_account_generic}";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>
            Le <strong><?= $this->credit->wallet->name_account_generic ?></strong> à fait l'objet d'un <strong>changement d'un jour de prélèvement</strong>.
            Le jour sélectionner est le <strong><?= $this->credit->prlv_day ?></strong> ce qui porte votre prochaine échéance au <strong><?= $this->credit->first_payment_at->format('d/m/Y') ?></strong>
        </p>
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
        $message->view("emails.customer.change_prlv_day", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-calendar-days",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->credit]
        ];
    }
}
