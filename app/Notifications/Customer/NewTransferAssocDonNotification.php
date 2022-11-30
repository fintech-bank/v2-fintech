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

class NewTransferAssocDonNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerTransfer $transfer;
    private array $association;
    private array $docs;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerTransfer $transfer
     * @param array $association
     * @param array $docs
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerTransfer $transfer, array $association,array $docs, string $category)
    {
        $this->customer = $customer;
        $this->transfer = $transfer;
        $this->association = $association;
        $this->docs = $docs;
        $this->title = "Nouveau dons à une association";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Votre virement vers l'association <strong><?= $this->association['name'] ?></strong> d'un montant de <strong><?= $this->transfer->amount_format ?></strong> à été prise en compte.</p>
        <p>Vous trouverez ci-joint le formulaire transmis à l'organisme dont vous avez fait le don.</p>
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
        $message->view("emails.customer.new_transfer_assoc_don", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        foreach ($this->docs as $doc) {
            $message->attach($doc['url']);
        }

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-hand-holding-dollar",
            "color" => "success",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->transfer, $this->association]
        ];
    }
}
