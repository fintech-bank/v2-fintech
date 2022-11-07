<?php

namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use Akibatech\FreeMobileSms\Notifications\FreeMobileMessage;
use App\Models\Customer\CustomerSepa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewPrlvPresented extends Notification
{
    use Queueable;

    public CustomerSepa $sepa;
    public string $title;
    public string $link;
    public string $message;

    /**
     * Create a new notification instance.
     *
     * @param CustomerSepa $sepa
     */
    public function __construct(CustomerSepa $sepa)
    {
        //
        $this->sepa = $sepa;
        $this->title = "Un nouveau prélèvement est arrivé sur votre compte";
        $this->message = $this->getMessage();
        $this->link = "/customer/prlv/".$this->sepa->uuid;
    }

    private function getMessage()
    {
        $message = "Nous vous informons de l'arrivé d'un nouveau prélèvement sur votre compte <strong>".$this->sepa->wallet->name_account_generic.".</strong>\n";
        $message .= "Pour plus d'information, nous vous invitons à consulter le details.";

        return $message;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->choiceChannel();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message =  (new MailMessage);
        $message->subject($this->title);

        $message->view('emails.customer.new_prlv', [
            'sepa' => $this->sepa,
            'content' => $this->message,
            'customer' => $this->sepa->wallet->customer
        ]);

        $message->actionUrl = $this->link;
        $message->actionText = "Plus d'information";

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
            'icon' => 'fa-arrow-right-arrow-left',
            'color' => 'primary',
            'title' => $this->title,
            'text' => $this->message,
            'time' => now()->shortAbsoluteDiffForHumans(),
            'link' => $this->link
        ];
    }

    public function toFreeMobile($notifiable)
    {
        $message = (new FreeMobileMessage());
        $message->message($this->message);

        return $message;

    }

    public function toTwilio($notifiable)
    {
        $message = (new TwilioSmsMessage());
        $message->content($this->message);

        return $message;
    }

    private function choiceChannel()
    {
        if (config('app.env') == 'local') {
            if($this->sepa->wallet->customer->setting->notif_sms) {
                return [FreeMobileChannel::class];
            }

            if($this->sepa->wallet->customer->setting->notif_mail) {
                return 'mail';
            }

            return 'database';
        } else {

            if($this->sepa->wallet->customer->setting->notif_sms) {
                return [TwilioChannel::class];
            }

            if($this->sepa->wallet->customer->setting->notif_mail) {
                return 'mail';
            }

            return 'database';

        }

    }
}
