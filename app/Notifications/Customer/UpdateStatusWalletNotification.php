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
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerWallet $wallet
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerWallet $wallet, string $category)
    {
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->title = "Information sur votre compte bancaire";
        $this->message = $this->getMessage();
        $this->link = "";

        $this->category = $category;
    }

    public function getMessage()
    {
        return match($this->wallet->status) {
            "pending" => $this->onPending(),
            "active" => $this->onActive(),
            "suspended" => $this->onSuspended(),
            "closed" => $this->onClosed()
        };
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
            "category" => $this->category,
            "models" => [$this->customer, $this->wallet]
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

    private function onPending()
    {
        ob_start();
        ?>
        <p>Votre compte <strong><?= $this->wallet->number_account ?></strong> est maintenant <span class="fw-bolder text-<?= $this->wallet->status_color ?>"><?= $this->wallet->status_text ?></span> </p>
        <p>Votre compte est actuellement en train d'être ouvert par notre service financier.</p>
        <?php
        return ob_get_clean();
    }
    private function onActive()
    {
        ob_start();
        ?>
        <p>Votre compte <strong><?= $this->wallet->number_account ?></strong> est maintenant <span class="fw-bolder text-<?= $this->wallet->status_color ?>"><?= $this->wallet->status_text ?></span> </p>
        <p>Vous pouvez dorénavant utiliser votre compte bancaire, comme il vous plaira.<br>Si vous avez des questions relatives à ce compte, n'hésitez pas à contacter votre conseiller clientele.</p>
        <?php
        return ob_get_clean();
    }
    private function onSuspended()
    {
        ob_start();
        ?>
        <p>Votre compte <strong><?= $this->wallet->number_account ?></strong> est maintenant <span class="fw-bolder text-<?= $this->wallet->status_color ?>"><?= $this->wallet->status_text ?></span> </p>
        <p>Votre compte est actuellement bloqué par nos services.<br>Pour plus de renseignement, contacter votre conseiller clientele.</p>
        <?php
        return ob_get_clean();
    }
    private function onClosed()
    {
        ob_start();
        ?>
        <p>Votre compte <strong><?= $this->wallet->number_account ?></strong> est maintenant <span class="fw-bolder text-<?= $this->wallet->status_color ?>"><?= $this->wallet->status_text ?></span> </p>
        <p>Votre compte a été clôturé par nos services.</p>
        <?php
        return ob_get_clean();
    }
}

