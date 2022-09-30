<?php

namespace App\Listeners;

use App\Events\DelegateBalanceCollected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DelegateBalanceCollectedListener
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
     * @param  DelegateBalanceCollected  $event
     * @return void
     */
    public function handle(DelegateBalanceCollected $event)
    {
        //
    }
}
