<?php

namespace App\Notifications\Testing\Customer;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Minishlink\WebPush\WebPush;
use NotificationChannels\Pushbullet\PushbulletChannel;
use NotificationChannels\Pushbullet\PushbulletMessage;
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

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
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable)
    {
        return (new WebPushMessage)
            ->title(config('app.name')." - Votre code de carte bancaire")
            ->icon(public_path().'/storage/icon/credit-card.png')
            ->body("Votre code de carte bleu $this->card->number est le $this->card_code");
    }
}
