<?php

namespace App\Listeners;

use App\Events\OrderMarkedAsWaitingDeliver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMarkedAsWaitingDeliverListener
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
     * @param  OrderMarkedAsWaitingDeliver  $event
     * @return void
     */
    public function handle(OrderMarkedAsWaitingDeliver $event)
    {
        //
    }
}
