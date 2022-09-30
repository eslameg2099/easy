<?php

namespace App\Listeners;

use App\Events\OrderMarkedAsDelivering;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMarkedAsDeliveringListener
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
     * @param  OrderMarkedAsDelivering  $event
     * @return void
     */
    public function handle(OrderMarkedAsDelivering $event)
    {
        //
    }
}
