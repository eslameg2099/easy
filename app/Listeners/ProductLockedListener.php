<?php

namespace App\Listeners;

use App\Events\ProductLocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductLockedListener
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
     * @param  ProductLocked  $event
     * @return void
     */
    public function handle(ProductLocked $event)
    {
        //
    }
}
