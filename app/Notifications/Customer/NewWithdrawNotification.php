<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWithdraw;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewWithdrawNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerWithdraw $withdraw;

    /**
     * @param Customer $customer
     * @param CustomerWithdraw $withdraw
     */
    public function __construct(Customer $customer, CustomerWithdraw $withdraw)
    {
        $this->customer = $customer;
        $this->withdraw = $withdraw;
        $this->title = "Comptes & Moyens de Paiements";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="fw-bolder fs-2 mb-5">Un retrait récent mérite votre attention</div>
        <p>Un retrait d'un montant de <strong><?= $this->withdraw->amount_format ?></strong> a été effectué chez <?= $this->withdraw->dab->name ?>.</p>
        <?php
        return ob_get_clean();
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {

            return "database";
        } else {

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
        $message->view("emails.customer.new_withdraw", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-money-bill-transfer",
            "color" => "success",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
