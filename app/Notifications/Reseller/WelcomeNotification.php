<?php

namespace App\Notifications\Customer\Customer\Reseller;

use App\Models\Reseller\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * @var Reseller
     */
    public $reseller;
    public $password;

    /**
     * Create a new notification instance.
     *
     * @param Reseller $reseller
     * @param $password
     */
    public function __construct(Reseller $reseller, $password)
    {
        //
        $this->reseller = $reseller;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage())->view('emails.reseller.welcome', [
            'reseller' => $this->reseller,
            'password' => $this->password
        ]);

        $message->attach(public_path('/storage/reseller/'.$this->reseller->user->id.'/contrat.pdf'));
        $message->subject("Bienvenue dans le groupe des distributeurs de FINTECH");

        return $message;
    }
}
