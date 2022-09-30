<?php

namespace App\Listeners;

use App\Events\OrderMarkedAsDelivered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMarkedAsDeliveredListener
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
     * @param  OrderMarkedAsDelivered  $event
     * @return void
     */
    public function handle(OrderMarkedAsDelivered $event)
    {
        //
    }
}
