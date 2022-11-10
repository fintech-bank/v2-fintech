<?php

namespace App\Notifications\Customer\Customer\Customer;

use App\Models\Core\Package;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdateTypeAccountNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public Package $type;

    public string $title = "Votre compte en ligne";
    public string $pathDocument;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param Package $type
     * @param string $pathDocument
     */
    public function __construct(Customer $customer, Package $type, string $pathDocument)
    {
        //
        $this->customer = $customer;
        $this->type = $type;
        $this->pathDocument = $pathDocument;
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
        $message = (new MailMessage())->view('emails.customer.update_type_account', [
            'customer' => $this->customer,
            'type' => $this->type,
        ]);

        $message->attach(public_path($this->pathDocument));
        $message->subject = $this->title;
        $message->introLines = [
            "Informations sur la gestion de votre compte"
        ];

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
            'title' => $this->title,
            'text' => "Votre compte est passée à l'offre ".$this->type->name.' à '.eur($this->type->price),
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
