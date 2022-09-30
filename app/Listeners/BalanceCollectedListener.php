<?php

namespace App\Listeners;

use App\Events\BalanceCollected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BalanceCollectedListener
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
     * @param  BalanceCollected  $event
     * @return void
     */
    public function handle(BalanceCollected $event)
    {
        //
    }
}
