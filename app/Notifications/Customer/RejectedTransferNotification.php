<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class RejectedTransferNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerTransfer $transfer;
    public string $reason;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerTransfer $transfer
     * @param string $reason
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerTransfer $transfer, string $reason, string $category)
    {
        $this->customer = $customer;
        $this->transfer = $transfer;
        $this->reason = $reason;
        $this->category = $category;
        $this->title = "Rejet de virement bancaire";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Le virement bancaire <strong><?= $this->transfer->reference ?></strong> à été rejeté</p>
        <p>La raison est la suivante: <span class="text-danger"><?= $this->reason ?></span>.</p>
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
        $message->view("emails.customer.rejected_transfer", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-exclamation-triangle",
            "color" => "danger",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->transfer, $this->reason]
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
?>
