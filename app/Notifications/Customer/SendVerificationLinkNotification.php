<?php

namespace App\Notifications\Customer\Customer\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationLinkNotification extends Notification
{
    use Queueable;

    public Customer $customer;
    public string $link;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param string $link
     */
    public function __construct(Customer $customer, string $link)
    {
        //
        $this->customer = $customer;
        $this->link = $link;
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
        return (new MailMessage)
                    ->subject("Vérifier votre identité")
                    ->action("Vérifier mon identité", $this->link)
                    ->view("emails.customer.send_verification_link", [
                        'customer' => $this->customer,
                    ]);
    }
}
