<?php

namespace App\Notifications\Customer\Customer\Customer;

use App\Helper\CustomerHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerInsurance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContractInsurance extends Notification
{
    use Queueable;

    public $customer;
    public $contract;
    public $documents;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerInsurance $contract
     * @param $documents
     */
    public function __construct(Customer $customer, CustomerInsurance $contract, $documents)
    {
        //
        $this->customer = $customer;
        $this->contract = $contract;
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
        $message = (new MailMessage())->view('emails.customer.new_contract_insurance', [
            'customer' => $this->customer,
            'contract' => $this->contract
        ]);

        foreach ($this->documents as $document) {
            $message->attach(public_path('/storage/'.$document['url']));
        }
        $message->subject("Votre Contrat d'assurance: ".$this->contract->package->name);

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
            'icon' => 'fa-'.$this->contract->package->type->icon,
            'color' => 'primary',
            'title' => "Votre contrat d'assurance ".$this->contract->package->type->name,
            'text' => "Vous venez de souscrire à une assurance de type: <strong>".$this->contract->package->type->name."</strong>",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
