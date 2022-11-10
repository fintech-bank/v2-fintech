<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewWalletNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerWallet $wallet;

    /**
     * @param Customer $customer
     * @param CustomerWallet $wallet
     */
    public function __construct(Customer $customer, CustomerWallet $wallet)
    {
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->title = "Nouveau compte bancaire disponible";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        $message = "<p>Votre compte bancaire N°".$this->wallet->number_account." à été créer par notre service financier.</p>";
        $message .= "<p>Afin de terminer l'ouverture de ce compte, un e-mail vous à été envoyer avec une demande de signature pour le document : 'Convention de compte'</p>";
        return $message;
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
        $message->view("emails.customer.new_wallet", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-wallet",
            "color" => "success",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
