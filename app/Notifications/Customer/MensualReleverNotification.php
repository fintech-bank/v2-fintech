<?php

namespace App\Notifications\Customer;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use App\Models\Customer\CustomerDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;

class MensualReleverNotification extends Notification
{

    use Queueable;

    public string $title;
    public string $link;
    public string $message;
    public CustomerDocument $file;

    /**
     * Create a new notification instance.
     *
     * @param CustomerDocument $file
     */
    public function __construct(CustomerDocument $file)
    {
        $this->title = "De nouveaux relevés sont disponible";
        $this->message = $this->getMessage();
        $this->link = '';
        $this->file = $file;
    }

    private function getMessage()
    {
        $message = "Nous vous informons que de nouveaux documents ont été mis à disposition sur votre Espace Client.<br>";
        $message .= "Pensez à sauvegarder régulièrement vos documents sur le support de votre choix";

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
        $message =  (new MailMessage);
        $message->subject($this->title);

        $message->view('emails.customer.mensual_relever', [
            'content' => $this->message,
            'customer' => $this->file->customer
        ]);

        $message->attach(public_path($this->file->url_folder));

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
            'icon' => 'fa-file-pdf',
            'color' => 'primary',
            'title' => $this->title,
            'text' => $this->message,
            'time' => now()->shortAbsoluteDiffForHumans(),
            'link' => $this->link
        ];
    }

    private function choiceChannel()
    {
        if (config('app.env') == 'local') {
            if($this->file->customer->setting->notif_sms) {
                return [FreeMobileChannel::class];
            }

            if($this->file->customer->setting->notif_mail) {
                return 'mail';
            }

            return 'database';
        } else {

            if($this->file->customer->setting->notif_sms) {
                return [TwilioChannel::class];
            }

            if($this->file->customer->setting->notif_mail) {
                return 'mail';
            }

            return 'database';

        }

    }
}
