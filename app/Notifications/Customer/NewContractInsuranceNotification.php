<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerInsurance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewContractInsuranceNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerInsurance $contract;
    public array $documents;

    /**
     * @param Customer $customer
     * @param CustomerInsurance $contract
     * @param array $documents
     */
    public function __construct(Customer $customer, CustomerInsurance $contract, array $documents)
    {
        $this->customer = $customer;
        $this->contract = $contract;
        $this->documents = $documents;
        $this->title = "Votre contrat d'assurance: ".$this->contract->package->name;
        $this->message = $this->getMessage();
        $this->link = "";
    }

    private function getMessage()
    {
        $message = "<p>Vous avez souscrit à notre offre d'assurance : <strong>{$this->contract->package->name}</strong> et nous vous remercions.</p>";
        $message .= "<p>Voici un récapitulatif de votre souscription:</p>";
        $message .= "<ul>";
        $message .= "<li><strong>Référence:</strong> {$this->contract->reference}</li>";
        $message .= "<li><strong>Offre:</strong> {$this->contract->form->name}</li>";
        $message .= "<li><strong>Tarif:</strong> {$this->contract->mensuality_format}</li>";
        $message .= "<li><strong>Fréquence de prélèvement:</strong> {$this->contract->type_prlv_text}</li>";
        $message .= "<li><strong>Date d'effet:</strong> {$this->contract->effect_date->format('d/m/Y')}</li>";
        $message .= "</ul>";
        $message .= "<p>Les documents relatifs à votre souscription sont disponibles dans votre espace client ainsi qu'en pièces jointes de ce mail.</p>";
        $message .= "<ul>";
        $message .= "<li>Condition Général {$this->contract->package->name}</li>";
        $message .= "<li>DDAC {$this->contract->package->name}</li>";
        $message .= "<li>Document d'information sur le produit d'assurance {$this->contract->package->name}</li>";
        $message .= "<li>Synthèse des echanges {$this->contract->package->name}</li>";
        $message .= "<li>Condition Particuliere {$this->contract->package->name}</li>";
        $message .= "<li>Conditions appliques aux operations bancaire</li>";
        $message .= "</ul>";
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
        $message->subject($this->title);

        $message->introLines = [
            "Mon contrat d'assurance"
        ];

        $message->view("emails.customer.new_contract_insurance", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        foreach ($this->documents as $document) {
            $message->attach(public_path('/storage/'.$document['url']));
        }

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-house-crack",
            "color" => "success",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
