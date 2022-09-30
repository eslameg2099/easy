<?php

namespace App\Events;

use App\Models\Delegate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\DelegateResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class DelegateDeclinedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Delegate
     */
    public $delegate;

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
        return new PresenceChannel('user-'.$this->delegate->id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return "delegate.declined";
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $this->delegate->is_approved = false;

        return [
            'delegate' => new DelegateResource($this->delegate),
        ];
    }
}
