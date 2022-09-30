<?php

namespace App\Listeners;

use App\Events\VerificationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerificationCreatedListener
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
     * @param  VerificationCreated  $event
     * @return void
     */
    public function handle(VerificationCreated $event)
    {
        //
    }
}
