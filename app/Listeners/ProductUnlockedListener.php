<?php

namespace App\Listeners;

use App\Events\ProductUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductUnlockedListener
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
     * @param  ProductUnlocked  $event
     * @return void
     */
    public function handle(ProductUnlocked $event)
    {
        //
    }
}
