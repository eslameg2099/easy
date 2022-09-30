<?php

namespace App\Models\Relations;

use App\Models\Product;

trait ShopRelations
{
    /**
     * Get the shop's products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
