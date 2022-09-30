<?php

namespace App\Observers;

use App\Models\Product;

class AssignCategoriesToProductObserver
{
    /**
     * Handle the product "saved" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function saved(Product $product)
    {
        $product->categories()->sync($product->category->getWithParents());
    }
}
