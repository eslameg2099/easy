<?php

namespace App\Events;

use App\Models\Admin;
use App\Models\Order;
use App\Models\shopOrder;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\ShopOrderResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Order
     */
    public Order $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Order $order
     */
    public function __construct(Order $order)
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
        
        foreach ($this->order->shopOrders as $shopOrder) {
            $channels[] = new PresenceChannel('user-'.$shopOrder->shop->user_id);
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
        return "new-order";
    }

    /**
     * Get the data to broadcast.
     *
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function broadcastWith()
    {
        dd($this->order->shopOrders);
        return [
            'order' => new ShopOrderResource($this->order),
        ];

        // return new ShopOrderResource($this->order);
    }
}
