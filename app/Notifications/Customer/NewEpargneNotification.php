<?php

namespace App\Notifications\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEpargneNotification extends Notification
{
    use Queueable;

    public Customer $customer;
    public CustomerWallet $wallet;
    public array $documents;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerWallet $wallet
     * @param array $documents
     */
    public function __construct(Customer $customer, CustomerWallet $wallet, array $documents)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
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
            'wallet' => $this->wallet
        ]);

        foreach ($this->documents as $document) {
            $message->attach($document['url']);
        }

        $message->success();
        $message->introLines = [
            'Bien évidement nous continuons à vous accompagnés dans votre quotidien !'
        ];
        $message->subject("Votre nouveau compte épargne est disponible");

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
            'title' => "Nouveau compte épargne",
            'text' => "Un nouveau compte épargne est disponible pour son utilisation.",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
