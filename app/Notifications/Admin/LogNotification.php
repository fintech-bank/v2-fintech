<?php

namespace App\Notifications\Admin;

use App\Helper\LogHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LogNotification extends Notification
{
    use Queueable;

    public $type;

    public $message;

    /**
     * Create a new notification instance.
     *
     * @param $type
     * @param $message
     */
    public function __construct($type, $message)
    {
        //
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'icon' => LogHelper::getTypeTitleIcon($this->type),
            'color' => LogHelper::getTypeTitleColor($this->type),
            'title' => 'Informations',
            'text' => $this->message,
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
