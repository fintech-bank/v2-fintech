<?php

namespace App\Notifications\Reseller;

use App\Models\Core\Invoice;
use App\Models\Reseller\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvoicePaymentNotification extends Notification
{
    use Queueable;

    /**
     * @var Invoice
     */
    public $invoice;
    /**
     * @var Reseller
     */
    public $reseller;

    /**
     * Create a new notification instance.
     *
     * @param Invoice $invoice
     * @param Reseller $reseller
     */
    public function __construct(Invoice $invoice, Reseller $reseller)
    {
        //
        $this->invoice = $invoice;
        $this->reseller = $reseller;
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
        $message = (new MailMessage())->view('emails.reseller.invoice_payment', [
            'reseller' => $this->reseller,
            'invoice' => $this->invoice
        ]);

        $message->subject("FINTECH - Paiement de la facture ".$this->invoice->reference);
        $message->from('no-reply@fintech.io');

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
            'icon' => 'fa-credit-card',
            'color' => 'primary',
            'title' => "Paiement de la facture ".$this->invoice->reference,
            'text' => "Un paiement de ".$this->invoice->payment->amount_format." à été envoyé sur votre compte pour la facture ".$this->invoice->reference,
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
