<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class UpdateStatusWalletNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerWallet $wallet;
    public string $status;

    /**
     * @param Customer $customer
     * @param CustomerWallet $wallet
     * @param string $status
     */
    public function __construct(Customer $customer, CustomerWallet $wallet, string $status)
    {
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->status = $status;
        $this->title = "Information sur votre compte bancaire";
        $this->message = $this->getMessage();
        $this->link = "";

    }

    public function getMessage()
    {
        $message = "Votre compte N°".$this->wallet->number_account." est maintenant <span class='fw-bolder text-'".$this->wallet->status_color."'>".$this->wallet->status_text."</span>";
        switch ($this->wallet->status) {
            case 'pending':
                $message .= "<p>Votre compte est actuellement en train d'être ouvert par notre service financier.</p>";
                break;
            case 'active':
                $message .= "<p>Vous pouvez dorénavant utiliser votre compte bancaire, comme il vous plaira.<br>Si vous avez des questions relatives à ce compte, n'hésitez pas à contacter votre conseiller clientele.</p>";
                break;
            case 'suspended':
                $message .= "<p>Votre compte est actuellement bloqué par nos services.<br>Pour plus de renseignement, contacter votre conseiller clientele.</p>";
                break;
            case 'closed':
                $message .= "<p>Votre compte a été clôturé par nos services.</p>";
                break;
        }
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if($this->customer->setting->notif_sms) {
                return [FreeMobileChannel::class];
            }

            if($this->customer->setting->notif_mail) {
                return "mail";
            }

            return "database";
        } else {

            if($this->customer->setting->notif_sms) {
                return [TwilioChannel::class];
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
        $message->view("emails.customer.update_status_wallet", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-".$this->wallet->getStatus($this->wallet->status),
            "color" => $this->wallet->status_color,
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
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
