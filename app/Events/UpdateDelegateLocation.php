<?php

namespace App\Events;

use App\Models\Delegate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\ShopOrderResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateDelegateLocation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\ShopOrder
     */
    public Delegate $delegate;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Delegate $delegate
     */
    public function __construct(Delegate $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('delegate-'. $this->delegate->id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return "location.updated";
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'lat' => (float) $this->delegate->lat,
            'lng' => (float) $this->delegate->lng,
        ];
    }
}
