<?php

namespace App\Events;

use App\Models\DelegateCollect;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DelegateBalanceCollected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\DelegateCollect
     */
    public DelegateCollect $collect;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\DelegateCollect $collect
     */
    public function __construct(DelegateCollect $collect)
    {
        $this->collect = $collect;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
