<?php
namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewPretNotification extends Notification
{

    public string $title;
    public string $link;
    public string $message;
    public Customer $customer;
    public CustomerPret $pret;
    public array $documents;
    private string $category;

    /**
     * @param Customer $customer
     * @param CustomerPret $pret
     * @param array $documents
     * @param string $category
     */
    public function __construct(Customer $customer, CustomerPret $pret, array $documents, string $category)
    {
        $this->customer = $customer;
        $this->pret = $pret;
        $this->documents = $documents;
        $this->title = "Votre souscription au ".$pret->plan->name;
        $this->message = $this->getMessage();
        $this->link = route('customer.pret.perso');
        $this->category = $category;
    }

    private function getMessage(): bool|string
    {
        ob_start();
        ?>
        <p>Vous venez de souscrire au <strong><?= $this->pret->plan->name ?></strong> en date du <strong><?= $this->pret->created_at->format('d/m/Y') ?></strong> et nous en remercions.</p>
        <?php if($this->pret->plan->tarif->type_taux == 'variable'): ?>
        <p>Sachez que ce type de crédit est dit à taux variable, c'est-à-dire que le taux en vigueurs est variable en fonction de la somme utilisé et non emprunter.<br>Par Example:</p>
        <i>Un prêt d'un montant de 3000 € accordée et de 300 € utilisé, le taux pris en compte est basée sur les 300 € utilisé et non les 3000 €</i>
        <p>Le taux pour ce crédit varie entre <strong><?= $this->pret->plan->tarif->max_interest ?></strong> et <strong><?= $this->pret->plan->tarif->max_interest ?></strong></p>
        <?php endif; ?>
        <p>Voici un récapitulatif de votre crédit:</p>
        <table class="table table-striped table-sm">
            <tbody>
                <tr>
                    <td class="fw-bold">Type de Crédit:</td>
                    <td><?= \Str::ucfirst($this->pret->plan->tarif->type_taux) ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Montant Accordée:</td>
                    <td><?= $this->pret->amount_loan_format ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Durée du prêt:</td>
                    <td><?= $this->pret->duration ?> Mois</td>
                </tr>
                <tr>
                    <td class="fw-bold">Mensualité:</td>
                    <td><?= $this->pret->mensuality_format ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Intêret:</td>
                    <td><?= $this->pret->amount_interest ?></td>
                </tr>
                <?php if($this->pret->plan->tarif->type_taux == 'variable'): ?>
                    <tr>
                        <td class="fw-bold">TAEG Révisable:</td>
                        <td><?= $this->pret->taux_variable ?> %</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td class="fw-bold">TAEG:</td>
                        <td><?= $this->pret->plan->tarif->interest ?> %</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($this->pret->customer->documents()->where('reference', $this->pret->reference)->where('signable', true)->where('signed_by_client', false)->count() > 0): ?>
        <p>
            Notre système nous indique également que certains documents ne sont pas encore signés.<br>
            Veuillez cliquer sur le bouton ci-dessous pour accéder à votre offre de prêt et signer tous les documents.<br>
            Sans votre signature dans un délai résonnable, votre offre de prêt ne sera pas traité dans les bonnes conditions.
        </p>
        <?php endif; ?>
        <p>Toute l'équipe de <?= config('app.name') ?> vous remercie de votre confiance.</p>
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
        $message->view("emails.customer.new_pret", [
            "content" => $this->message,
            "customer" => $this->customer,
        ]);

        foreach ($this->documents as $document) {
            $message->attach($document['url']);
        }

        $message->introLines = [
            'Un crédit vous engage et doit être remboursé<br>',
            'Veuillez vérifier vos capacités de remboursement avant de souscrire.'
        ];

        $message->actionText = "Mon offre de prets";
        $message->actionUrl = $this->link;

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            "icon" => "fa-wallet",
            "color" => "primary",
            "title" => $this->title,
            "text" => $this->message,
            "time" => now(),
            "link" => $this->link,
            "category" => $this->category,
            "models" => [$this->customer, $this->pret]
        ];
    }
}
