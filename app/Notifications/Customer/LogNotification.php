<?php

namespace App\Notifications\Customer;

use App\Helper\LogHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LogNotification extends Notification
{
    use Queueable;

    public $type;

    public $message;
    /**
     * @var null
     */
    public $content;

    /**
     * Create a new notification instance.
     *
     * @param $type
     * @param $message
     * @param null $content
     */
    public function __construct($type, $message, $content = null)
    {
        //
        $this->type = $type;
        $this->message = $message;
        $this->content = $content;
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
            'text' => $this->message ?? 'Aucun Message',
            'content' => $this->content,
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
