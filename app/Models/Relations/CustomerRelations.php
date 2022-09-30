<?php

namespace App\Models\Relations;

use App\Models\Order;

trait CustomerRelations
{
    /**
     * Get all the user's orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
