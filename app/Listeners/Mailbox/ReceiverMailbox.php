<?php

namespace App\Listeners\Mailbox;

use App\Notifications\Mailbox\NewMailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReceiverMailbox
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\Mailbox\ReceiverMailbox $event
     * @return void
     */
    public function handle(\App\Events\Mailbox\ReceiverMailbox $event)
    {
        foreach ($event->mailbox->receivers as $receiver) {
            $receiver->user->notify(new NewMailNotification($event->mailbox));
        }
    }
}
