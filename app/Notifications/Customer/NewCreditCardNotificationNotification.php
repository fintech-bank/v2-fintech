<?php

namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewCreditCardNotificationNotification extends Notification
{
    public Customer $customer;
    public CustomerCreditCard $card;
    public string $title;
    public string $link;
    public string $message;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerCreditCard $card
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerCreditCard $card, string $category)
    {
        $this->customer = $customer;
        $this->card = $card;
        $this->title = "Nouvelle Carte Bancaire disponible en agence";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        $message = "<p>Une nouvelle carte bancaire est disponible en agence.<br>Voici un récapitulatif de votre carte bancaire:</p>";
        ob_start();
        ?>
        <div class="border border-2 border-primary rounded-2 p-5">
            <ul class="list-unstyled">
                <li><span class="bullet bullet-dot bg-info me-5"></span> <strong>Produit:</strong>Carte
                    Bancaire <?= $this->card->support->name; ?></li>
                <li><span class="bullet bullet-dot bg-info me-5"></span> <strong>Numéro de la
                        carte:</strong> <?= $this->card->number_format; ?></li>
                <li><span class="bullet bullet-dot bg-info me-5"></span> <strong>Type de
                        carte:</strong> <?= \Str::ucfirst($this->card->type); ?></li>
                <li><span class="bullet bullet-dot bg-info me-5"></span>
                    <strong>Expiration:</strong> <?= $this->card->expiration; ?></li>
                <li><span class="bullet bullet-dot bg-info me-5"></span> <strong>Type de
                        débit:</strong> <?= $this->card->debit_format; ?></li>
                <?php if ($this->card->debit == 'differed'): ?>
                    <li><span class="bullet bullet-dot bg-info me-5"></span> <strong>Montant
                            Différé:</strong> <?= eur($this->card->differed_limit); ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <?php
        $message .= ob_get_clean();
        return $message;
    }

    private function choiceChannel()
    {
        if (config("app.env") == "local") {
            if ($this->customer->setting->notif_mail) {
                return ["mail", "database"];
            }

            return "database";
        } else {
            if ($this->customer->setting->notif_mail) {
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
        $message->view("emails.customer.new_credit_card", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

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
            "category" => $this->category,
            "models" => [$this->customer, $this->card]
        ];
    }
}
