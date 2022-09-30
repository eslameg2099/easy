<?php

namespace App\Models\Relations;

use App\Models\Customer;
use App\Models\Delegate;
use App\Models\ShopOwner;

trait CityRelations
{
    /**
     * Get all the city customers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get all the city delegates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function delegates()
    {
        return $this->hasMany(Delegate::class);
    }

    /**
     * Get all the city shop owners.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopOwners()
    {
        return $this->hasMany(ShopOwner::class);
    }
}
