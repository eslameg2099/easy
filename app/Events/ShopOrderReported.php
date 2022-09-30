<?php

namespace App\Events;

use App\Models\Report;
use Illuminate\Broadcasting\Channel;
use App\Http\Resources\ReportResource;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\ShopOrderResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ShopOrderReported implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Report
     */
    public Report $report;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Report $report
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('user-'.$this->report->order->shop->user_id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return "new.report";
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'report' => new ReportResource($this->report),
        ];
    }
}
