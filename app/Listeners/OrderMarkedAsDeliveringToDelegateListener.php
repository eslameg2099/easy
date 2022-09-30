<?php

namespace App\Listeners;

use App\Events\OrderMarkedAsDeliveringToDelegate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMarkedAsDeliveringToDelegateListener
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
     * @param  OrderMarkedAsDeliveringToDelegate  $event
     * @return void
     */
    public function handle(OrderMarkedAsDeliveringToDelegate $event)
    {
        //
    }
}
