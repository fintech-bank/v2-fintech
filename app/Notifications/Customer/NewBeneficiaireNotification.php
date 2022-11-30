<?php

namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewBeneficiaireNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public string $category;
    private CustomerBeneficiaire $beneficiaire;

    /**
     * @param Customer $customer
     * @param CustomerBeneficiaire $beneficiaire
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerBeneficiaire $beneficiaire, string $category)
    {
        $this->customer = $customer;
        $this->beneficiaire = $beneficiaire;
        $this->title = "Nouveau Bénéficiaire";
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <div class="fw-bolder fs-2">Un nouveau compte bénéficiaire a été ajouté</div>
        <p>Le compte <?= $this->beneficiaire->full_name ?> (<?= $this->beneficiaire->iban_format ?>) a bien été ajouté à vos comptes bénéficiaires. Réalisez dès maintenant des virements vers ce compte!</p>

        <div class="mt-15 d-flex flex-row rounded border border-primary p-5">
            <i class="fa-solid fs-2 fa-info-circle text-primary me-10"></i>
            <p>Vous pouvez effectuer des virements ponctuels, permanents (sauf pour les comptes bénéficiaires étrangers) ou internationaux en devise.</p>
        </div>
        <?php
        return ob_get_clean();
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
        $message->subject($this->title);
        $message->view("emails.customer.new_beneficiaire", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-user-circle",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->beneficiaire]
        ];
    }
}
