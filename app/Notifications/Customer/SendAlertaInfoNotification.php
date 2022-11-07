<?php

namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendAlertaInfoNotification extends Notification
{
    use Queueable;

    public CustomerWallet $wallet;
    public $waiting;
    public $mouvement;

    /**
     * Create a new notification instance.
     *
     * @param CustomerWallet $wallet
     * @param CustomerTransaction $waiting
     * @param CustomerTransaction $mouvement
     */
    public function __construct(CustomerWallet $wallet, CustomerTransaction $waiting, CustomerTransaction $mouvement)
    {
        //
        $this->wallet = $wallet;
        $this->waiting = $waiting;
        $this->mouvement = $mouvement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $message = 'Le '.now()->format('d/m/Y à H:i');
        $message .= "RELEVE FLASH";
        $message .= "Compte: ".$this->wallet->balance_actual;

        return [
            'icon' => 'fa-bolt',
            'color' => 'primary',
            'title' => "Relevé Flash",
            'text' => $message,
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toFreeMobile($notifiable)
    {
        $message =  (new FreeMobileMessage(config('app.name')));
        $message->message('Le '.now()->format('d/m/Y à H:i'));
        $message->message("RELEVE FLASH");
        $message->message("Compte: ".$this->wallet->balance_actual);
        if(isset($this->waiting)) {
            $message->message("Dernière opération en cours: ".$this->waiting->amount_format.' ('.$this->waiting->updated_at->format('d/m').')');
        } else {
            $message->message("Pas d'opération en cours.");
        }

        if(isset($this->mouvement)) {
            $message->message("Dernière opération: ".$this->mouvement->amount_format.'('.$this->mouvement->confirmed_at->format('d/m').')');
        } else {
            $message->message("Pas de nouvelle opération.");
        }

        $message->message("Bonne journée !");

        return $message;
    }

    public function toTwilio($notifiable)
    {
        $message = (new TwilioSmsMessage());
        $message->content('Le '.now()->format('d/m/Y à H:i'));
        $message->content("RELEVE FLASH");
        $message->content("Compte: ".$this->wallet->balance_actual);
        if(isset($this->waiting)) {
            $message->content("Dernière opération en cours: ".$this->waiting->amount_format.' ('.$this->waiting->updated_at->format('d/m').')');
        } else {
            $message->content("Pas d'opération en cours.");
        }

        if(isset($this->mouvement)) {
            $message->content("Dernière opération: ".$this->mouvement->amount_format.'('.$this->mouvement->confirmed_at->format('d/m').')');
        } else {
            $message->content("Pas de nouvelle opération.");
        }

        $message->content("Bonne journée !");

        return $message;
    }

    private function choiceChannel()
    {
        if(config('app.env') == 'local') {
            return [FreeMobileChannel::class, 'database'];
        } else {
            return [TwilioChannel::class, 'database'];
        }
    }
}
