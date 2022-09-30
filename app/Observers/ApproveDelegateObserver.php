<?php

namespace App\Observers;

use App\Models\Delegate;
use App\Events\DelegateApprovedEvent;
use App\Events\DelegateDeclinedEvent;

class ApproveDelegateObserver
{
    /**
     * Handle the Delegate "saving" event.
     *
     * @param  \App\Models\Delegate  $delegate
     * @return void
     */
    public function saving(Delegate $delegate)
    {
        if ($delegate->isDirty('is_approved') && $delegate->id) {
            if ($delegate->is_approved) {
                broadcast(new DelegateApprovedEvent($delegate));
            } else {
                broadcast(new DelegateDeclinedEvent($delegate));
            }
        }
    }
}
