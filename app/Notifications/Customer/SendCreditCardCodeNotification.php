<?php

namespace App\Notifications\Customer;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushbullet\PushbulletChannel;
use NotificationChannels\Pushbullet\PushbulletMessage;
use NotificationChannels\Pushover\PushoverChannel;

class SendCreditCardCodeNotification extends Notification
{
    use Queueable;

    /**
     * @var int|int
     */
    public $card_code;
    /**
     * @var CustomerCreditCard
     */
    public $card;

    /**
     * Create a new notification instance.
     *
     * @param int $card_code
     * @param CustomerCreditCard $card
     */
    public function __construct(int $card_code, CustomerCreditCard $card)
    {
        //
        $this->card_code = $card_code;
        $this->card = $card;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [PushbulletChannel::class];
    }

    public function toPushbullet($notifiable)
    {
        return PushbulletMessage::create("Le code de la carte bancaire ".$this->card->number." est le $this->card_code")
            ->note()
            ->title(config('app.name'));
    }
}
