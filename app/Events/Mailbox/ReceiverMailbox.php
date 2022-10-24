<?php

namespace App\Events\Mailbox;

use App\Models\Core\Mailbox;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReceiverMailbox implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Mailbox
     */
    public $mailbox;

    /**
     * Create a new event instance.
     *
     * @param Mailbox $mailbox
     */
    public function __construct(Mailbox $mailbox)
    {
        //
        $this->mailbox = $mailbox;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('mailbox');
    }

    public function broadcastAs()
    {
        return 'new-mail-in-mailbox';
    }
}
