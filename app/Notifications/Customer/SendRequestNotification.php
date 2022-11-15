<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendRequestNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerRequest $request;

    /**
     * @param Customer $customer
     * @param CustomerRequest $request
     */
    public function __construct(Customer $customer, CustomerRequest $request)
    {
        $this->customer = $customer;
        $this->request = $request;
        $this->title = "Nouvelle requête ouverte dans votre espace";
        $this->message = $this->getMessage();
        $this->link = route('customer.document.request.show', $request->id);
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Une nouvelle requête est disponible dans votre espace client.<br>Voici un aperçu de la requête:</p>
        <div class="rounded rounded-2 p-5 bg-gray-300">
            <ul>
                <li><strong>Sujet:</strong> <?= $this->request->sujet ?></li>
                <li><strong>Référence:</strong> <?= $this->request->reference ?></li>
            </ul>
        </div>
        <p>Veuillez cliquer sur le bouton ci-dessous afin de répondre à cette requête.</p>
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
        $message->view("emails.customer.send_request", [
            "content" => $this->message,
            "customer" => $this->customer
        ]);

        $message->actionText = "Accéder à la requête";
        $message->actionUrl = $this->link;

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-question",
            "color" => "info",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
        ];
    }
}
