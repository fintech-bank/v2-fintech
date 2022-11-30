<?php

namespace App\Notifications\Reseller;

use App\Models\Core\Shipping;
use App\Models\Reseller\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ShipTpeNotificationP extends Notification
{
    use Queueable;

    /**
     * @var Reseller
     */
    public $reseller;
    /**
     * @var Shipping
     */
    public $shipping;

    /**
     * Create a new notification instance.
     *
     * @param Reseller $reseller
     * @param Shipping $shipping
     */
    public function __construct(Reseller $reseller, Shipping $shipping)
    {
        //
        $this->reseller = $reseller;
        $this->shipping = $shipping;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage())->view('emails.reseller.ship_tpe', [
            'reseller' => $this->reseller,
            'shipping' => $this->shipping
        ]);

        $message->subject("Notification d'envoie FINTECH, numéro de suivi ".$this->shipping->number_ship);
        $message->from('ship@fintech.io', 'FINTECH Transport');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'icon' => 'fa-box',
            'color' => 'primary',
            'title' => "Notification d'envoie FINTECH, numéro de suivi ".$this->shipping->number_ship,
            'text' => "La Commande de votre TPE à bien été prise en compte",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
