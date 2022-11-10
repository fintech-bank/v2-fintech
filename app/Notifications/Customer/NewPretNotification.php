<?php

namespace App\Notifications\Customer\Customer\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPretNotification extends Notification
{
    use Queueable;

    public Customer $customer;
    public CustomerPret $pret;
    public array $documents;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerPret $pret
     * @param array $documents
     */
    public function __construct(Customer $customer, CustomerPret $pret, array $documents)
    {
        //
        $this->customer = $customer;
        $this->pret = $pret;
        $this->documents = $documents;
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
        $message = (new MailMessage())->view('emails.customer.new_epargne', [
            'customer' => $this->customer,
            'pret' => $this->pret
        ]);

        foreach ($this->documents as $document) {
            $message->attach($document['url']);
        }

        $message->success();
        $message->introLines = [
            'Un crédit vous engage et doit être remboursé',
            'Veuillez vérifier vos capacités de remboursement avant de souscrire.'
        ];
        $message->subject("Nouvelle demande de crédit personnel");

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
            'icon' => 'fa-wallet',
            'color' => 'primary',
            'title' => "Nouvelle demande de crédit personnel",
            'text' => "Une proposition de crédit personnel est disponible dans votre espace",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
