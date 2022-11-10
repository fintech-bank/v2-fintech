<?php

namespace App\Notifications\Customer\Customer\Reseller;

use App\Models\Core\Invoice;
use App\Models\Reseller\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvoiceNotification extends Notification
{
    use Queueable;

    /**
     * @var Reseller
     */
    public $reseller;
    /**
     * @var Invoice
     */
    public $invoice;
    public $document;

    /**
     * Create a new notification instance.
     *
     * @param Reseller $reseller
     * @param Invoice $invoice
     * @param $document
     */
    public function __construct(Reseller $reseller, Invoice $invoice, $document)
    {
        //
        $this->reseller = $reseller;
        $this->invoice = $invoice;
        $this->document = $document;
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
        $message = (new MailMessage())->view('emails.reseller.invoice', [
            'reseller' => $this->reseller,
            'invoice' => $this->invoice
        ]);

        $message->attach(public_path('/storage/reseller/'.$this->reseller->user->id.'/'.$this->document.'.pdf'));

        $message->subject("FINTECH - Facture ".$this->invoice->reference);
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
            'icon' => 'fa-file-invoice',
            'color' => 'primary',
            'title' => "Nouvelle facture disponible",
            'text' => "La facture ".$this->invoice->reference." d'un montant de ".$this->invoice->amount_format." est disponible dans votre espace",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
