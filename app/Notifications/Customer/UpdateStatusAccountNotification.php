<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerHelper;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateStatusAccountNotification extends Notification
{
    use Queueable;

    /**
     * @var Customer
     */
    public $customer;
    /**
     * @var string|string
     */
    public $status;
    /**
     * @var string|string|null
     */
    public $reason;
    /**
     * @var string|string|null
     */
    public $nameDocument;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param string $status
     * @param string|null $reason
     * @param string|null $nameDocument
     */
    public function __construct(Customer $customer, string $status, string $reason = null, string $nameDocument = null)
    {
        //
        $this->customer = $customer;
        $this->status = $status;
        $this->reason = $reason;
        $this->nameDocument = $nameDocument;
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
        return (new MailMessage)
            ->subject('Votre compte en ligne')
            ->view('emails.customer.update_status_account', [
                'customer' => $this->customer,
                'statusLib' => CustomerHelper::getStatusOpenAccount($this->status),
                'status' => $this->status,
                'reason' => $this->reason,
            ]);
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
            'icon' => 'fa-euro-sign',
            'color' => 'primary',
            'title' => 'Votre compte bancaire',
            'text' => 'Le status de votre compte est passée à: '.CustomerHelper::getStatusOpenAccount($this->status),
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
