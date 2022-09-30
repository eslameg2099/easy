<?php

namespace App\Listeners;

use App\Events\UpdateDelegateLocation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateDelegateLocationListener
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
     * @param  UpdateDelegateLocation  $event
     * @return void
     */
    public function handle(UpdateDelegateLocation $event)
    {
        //
    }
}
