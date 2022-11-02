<?php

namespace App\Mail\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendVerificationLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public Customer $customer;
    public string $link;

    /**
     * Create a new message instance.
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
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Send Verification Link Mail',
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
            view: 'emails.customer.send_verification_link',
            with: [
                'actionText' => 'Vérifier mon identité',
                'actionUrl' => $this->link,
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
