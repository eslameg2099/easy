<?php

namespace App\Observers;

use App\Models\Address;

class AttachCitiesToAddressObserver
{
    /**
     * Handle the User "saved" event.
     *
     * @return void
     */
    public function saved(Address $Address)
    {
        if ($Address->city) {
            $Address->cities()->sync($Address->city->getModelWithParents());
        }
    }
}
