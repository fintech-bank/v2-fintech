<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NotifyTransferAssocNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    private CustomerTransfer $transfer;
    private array $association;
    private array $docs;

    /**
     * @param Customer $customer
     * @param CustomerTransfer $transfer
     * @param array $association
     * @param array $docs
     */
    public function __construct(Customer $customer, CustomerTransfer $transfer, array $association, array $docs)
    {
        $this->customer = $customer;
        $this->transfer = $transfer;
        $this->association = $association;
        $this->docs = $docs;
        $this->title = "Message à l'attention du président de l'association {$this->association['name']}";
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        ob_start();
        ?>

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
        $message->line("Un nouveau don en provenance de notre banque est actuellement en cours d'envoie, voici un récapitulatif:");
        $message->line('IBAN Emetteur: '.$this->transfer->wallet->iban_format);
        $message->line('Nom Emetteur: '.$this->transfer->wallet->customer->info->full_name);
        $message->line('Montant du don: '.$this->transfer->amount_format);
        $message->line('Un formulaire plus conséquent est en pièces jointes de ce mail avec toutes les informations du client en attente de reçu.');

        foreach ($this->docs as $doc) {
            $message->attach($doc['url']);
        }

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
        ];
    }
}
