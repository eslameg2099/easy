<?php

namespace App\Listeners;

use App\Events\OrderMarkedAsDeliveredToDelegate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMarkedAsDeliveredToDelegateListener
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
     * @param  OrderMarkedAsDeliveredToDelegate  $event
     * @return void
     */
    public function handle(OrderMarkedAsDeliveredToDelegate $event)
    {
        //
    }
}
