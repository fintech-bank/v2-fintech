<?php

namespace App\Notifications\Customer\Customer\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * @var Customer
     */
    public $customer;
    public $documents;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param $documents
     */
    public function __construct(Customer $customer, $documents)
    {
        //
        $this->customer = $customer;
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
        $message = (new MailMessage())->view('emails.customer.welcome', [
            'customer' => $this->customer
        ]);

        foreach ($this->documents as $document) {
            $message->attach(public_path('/storage/'.$document['url']));
        }
        $message->subject("Bienvenue chez ".config('app.name'));

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
            //
        ];
    }
}
