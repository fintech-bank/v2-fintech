<?php
namespace App\Notifications\Customer\Ficap;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPretCaution;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class NewCautionFicapNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public CustomerPretCaution $customer;
    public string $password;

    /**
     * @param CustomerPretCaution $customer
     * @param string $password
     */
    public function __construct(CustomerPretCaution $customer, string $password)
    {
        $this->customer = $customer;
        $this->password = $password;
        $this->title = "Cautionnement du ".$this->customer->loan->wallet->name_account_generic;
        $this->message = $this->getMessage();
        $this->link = "https://ficap.fintech.ovh";
    }

    private function getMessage()
    {
        ob_start();
        ?>
        <p>Vous avez souhaité être la caution <?= \Str::ucfirst($this->customer->getType('text')) ?> de <?= $this->customer->loan->customer->info->full_name ?> pour le <?= $this->customer->loan->wallet->name_account_generic ?>.</p>
        <p>Le service FICAP vous permet d'acceder aux informations et suivie du ou des crédits dont vous êtes caution.</p>
        <p>Afin d'accéder à ce service, veuillez cliquer sur le bouton ci-dessous et connectez vous avec les identifiants suivant:</p>
        <ul>
            <li><strong>Email:</strong> <?= $this->customer->email ?></li>
            <li><strong>Mot de passe provisoire:</strong> <?= $this->password ?></li>
        </ul>
        <p class="text-danger">Ce mot de passe est provisoire, une fois connecter, il sera détruit et vous devrez redéfinir un nouveau mot de passe d'accès.</p>
        <?php
        return ob_get_clean();
    }

    private function choiceChannel()
    {
        return "mail";
    }

    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage);
        $message->subject($this->title);
        $message->view("emails.customer.new_caution_ficap", [
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
        ];
    }
}
