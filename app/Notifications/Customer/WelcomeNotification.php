<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class WelcomeNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public array $documents;
    private string $category;

    /**
     * @param Customer $customer
     * @param array $documents
     * @param string $category
     */
    public function __construct(Customer $customer, array $documents, string $category)
    {
        $this->customer = $customer;
        $this->documents = $documents;
        $this->title = "Bienvenue chez ".config('app.name');
        $this->message = $this->getMessage();
        $this->link = "";
        $this->category = $category;
    }

    private function getMessage()
    {
        $message = "<p>Vous venez d'ouvrir un compte ".config('app.name').", Bienvenue</p>";
        $message .= "<p>Pour commencer, votre espace client est maintenant accessible avec votre identifiant et votre adresse mail:</p>";
        $message .= "<ul>";
        $message .= "<li><strong>Identifiant:</strong> {$this->customer->user->identifiant}</li>";
        $message .= "<li><strong>Email:</strong> {$this->customer->user->email}</li>";
        $message .= "<li><strong>Code SecurPass temporaire:</strong> ".base64_decode($this->customer->auth_code)."</li>";
        $message .= "<li><strong>Vérifier votre numéro de téléphone:</strong> <a href='".route('auth.verify.view')."'>Vérifier</a> </li>";
        $message .= "</ul>";
        $message .= "<p><strong>Une fois votre inscription au service effectuer, on vous demandera de signer un mandat de mobilité. Et on s'occupe de tout</strong> pour que vos prélèvements,
                et virement récurrent qui était sur votre ancien compte arrivent sur votre compte {{ config('app.name') }}.</p>";
        $message .= "<strong>De plus</strong>, vous trouverez en pièces jointes des documents à conserver :";
        $message .= "<ul>";
        $message .= "<li>Votre contrat</li>";
        $message .= "<li>Un guide sur la mobilité bancaire avec TransBank</li>";
        $message .= "</ul>";
        return $message;
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
        $message->introLines = [
            'NOUS AVONS HÂTE DE VOUS COMPTER PARMI NOUS'
        ];
        $message->view("emails.customer.welcome", [
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
            "icon" => "fa-hand",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer]
        ];
    }
}
