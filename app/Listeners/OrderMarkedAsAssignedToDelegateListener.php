<?php

namespace App\Listeners;

use App\Events\OrderMarkedAsAssignedToDelegate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMarkedAsAssignedToDelegateListener
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
     * @param  OrderMarkedAsAssignedToDelegate  $event
     * @return void
     */
    public function handle(OrderMarkedAsAssignedToDelegate $event)
    {
        //
    }
}
