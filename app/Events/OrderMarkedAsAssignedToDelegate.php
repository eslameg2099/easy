<?php

namespace App\Events;

use App\Models\Admin;
use App\Models\ShopOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\ShopOrderResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderMarkedAsAssignedToDelegate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\ShopOrder
     */
    public ShopOrder $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\ShopOrder $order
     */
    public function __construct(ShopOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];

        foreach (Admin::all() as $admin) {
            $channels[] = new PresenceChannel('user-'.$admin->id);
        }

        if ($id = $this->order->shop->user_id) {
            $channels[] = new PresenceChannel('user-'.$id);
        }

        if ($id = $this->order->delegate_id) {
            $channels[] = new PresenceChannel('user-'.$id);
        }

        if ($id = $this->order->order->user_id) {
            $channels[] = new PresenceChannel('user-'.$id);
        }

        return $channels;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return "order.assigned-to-delegate";
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'order' => new ShopOrderResource($this->order),
        ];
    }
}
