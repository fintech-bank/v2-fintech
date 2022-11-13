<?php

namespace App\Mail\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateStatusAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public Customer $customer;
    public string $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, string $status)
    {
        //
        $this->customer = $customer;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Votre compte en ligne',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.customer.update_status_account',
            with: [
                'introLines' => [
                    'Informations sur la gestion de votre compte'
                ]
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
