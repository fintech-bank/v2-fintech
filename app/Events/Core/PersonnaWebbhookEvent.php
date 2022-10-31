<?php

namespace App\Events\Core;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PersonnaWebbhookEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $paylod;

    /**
     * @param $paylod
     */
    public function __construct($paylod)
    {
        $this->paylod = $paylod;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('psersonna-channel');
    }
}
