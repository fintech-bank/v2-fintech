<?php

namespace App\Mail\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendSignateDocumentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public Customer $customer;
    public string $token;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     * @param string $token
     */
    public function __construct(Customer $customer,string $token)
    {
        //
        $this->customer = $customer;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Nouveau document en attente de signature',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customer.signate_document_request',
            with: [
                'actionText' => "Signez mon document",
                'actionUrl' => route('signate.show', $this->token),
                'introLines' => []
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
