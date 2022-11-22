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

class ReportEcheanceNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerPret $credit;

    /**
     * @param Customer $customer
     * @param CustomerPret $credit
     */
    public function __construct(Customer $customer, CustomerPret $credit)
    {
        $this->customer = $customer;
        $this->credit = $credit;
        $this->title = "Information sur le {$credit->wallet->name_account_generic}";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>
            Le <?= $this->credit->wallet->name_account_generic; ?> à fais l'objet d'un report d'échéance.<br>
            La prochaine échéance d'un montant de <strong><?= $this->credit->mensuality_format ?></strong> sera prélevé le <strong><?= $this->credit->first_payment_at->format('d/m/Y') ?></strong>.
        </p>
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
        $message->view("emails.customer.report_echeance", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-clock-rotate-left",
            "color" => "success",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}