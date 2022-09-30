<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductUpdatedListener
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
     * @param  ProductUpdated  $event
     * @return void
     */
    public function handle(ProductUpdated $event)
    {
        //
    }
}
