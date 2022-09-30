<?php

namespace App\Listeners;

use App\Events\ShopOrderReported;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShopOrderReportedListener
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
     * @param  ShopOrderReported  $event
     * @return void
     */
    public function handle(ShopOrderReported $event)
    {
        //
    }
}
