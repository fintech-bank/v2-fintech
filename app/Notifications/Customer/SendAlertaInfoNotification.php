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
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param CustomerWallet $wallet
     * @param CustomerTransaction|null $waiting
     * @param CustomerTransaction|null $mouvement
     */
    public function __construct(CustomerWallet $wallet, CustomerTransaction $waiting = null, CustomerTransaction $mouvement = null)
    {
        //
        $this->wallet = $wallet;
        $this->waiting = $waiting;
        $this->mouvement = $mouvement;
        $this->message = $this->getMessage();
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        $message = config('app.name')."<br>";
        $message .= 'Le ' . now()->format('d/m/Y à H:i').'<br>';
        $message .= "RELEVE FLASH<br>";
        $message .= "Compte: " . $this->wallet->balance_actual;

        if (isset($this->waiting)) {
            $message .= "Dernière opération en cours: " . $this->waiting->amount_format . ' (' . $this->waiting->updated_at->format('d/m') . ')';
        } else {
            $message .= "Pas d'opération en cours.";
        }

        if(isset($this->mouvement)) {
            $message .= "Dernière opération: " . $this->mouvement->amount_format . '(' . $this->mouvement->confirmed_at->format('d/m') . ')';
        } else {
            $message .= "Pas de nouvelle opération";
        }

        $message .= "Bonne journée !";

        return $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'icon' => 'fa-bolt',
            'color' => 'primary',
            'title' => "Relevé Flash",
            'text' => $this->message,
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toFreeMobile($notifiable)
    {
        $message = (new FreeMobileMessage());
        $message->message($this->message);

        return $message;

    }

    public function toTwilio($notifiable)
    {
        $message = (new TwilioSmsMessage());
        $message->content($this->message);

        return $message;
    }

    private function choiceChannel()
    {
        if (config('app.env') == 'local') {
            return [FreeMobileChannel::class, 'database'];
        } else {
            return [TwilioChannel::class, 'database'];
        }
    }
}
