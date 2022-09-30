<?php

namespace App\Listeners;

use App\Events\DelegateApprovedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DelegateApprovedListener
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
     * @param  DelegateApprovedEvent  $event
     * @return void
     */
    public function handle(DelegateApprovedEvent $event)
    {
        //
    }
}
