<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\ShopOrder;

class ShopOrderObserver
{
    /**
     * Handle the product "creating" event.
     *
     * @param  \App\Models\ShopOrder  $order
     * @return void
     */
    public function creating(ShopOrder $order)
    {
        $order->forceFill(['status' => Order::PENDING_STATUS]);
    }
}
