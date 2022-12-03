<?php

namespace App\Notifications\Other;

use App\Models\Core\Sponsorship;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSponsorshipFilleulNotification extends Notification
{
    public function __construct(public Sponsorship $sponsorship)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $message = (new MailMessage);
        $message->subject = "Ouvrez votre compte grâce à votre parrain";
        $message->introLines = [
            "Grâce à {$this->sponsorship->customer->info->full_name} profiter de 80 € grâce à son parrainage",
            "Et en plus 80 € comme offre de bienvenue, c'est noël chez ".config('app.name')
        ];

        $message->line("Un de nos clients sociétaire vous à enregistrer en tant que filleul.");
        $message->line("Si vous ouvrez un compte chez nous vous pourrez grâce à ce parrainage, bénéficier des avantages suivant:");
        $message->line('- 80 € reverser dans la semaine de l\'ouverture de votre nouveau compte');
        $message->line('- 80 € reverser immédiatement dès l\'ouverture de votre nouveau compte');
        $message->line('- Un mois offert sur l\'ouverture de votre compte');
        $message->line('- Plein d\'autre avantages');

        $message->line("N'hésitez plus et souscrivez !");

        $message->actionText = "Ouvrir mon compte";
        $message->actionUrl = route('auth.register.firstStep');

        return $message;
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
