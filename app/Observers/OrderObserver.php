<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the product "creating" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function creating(Order $order)
    {
        $order->forceFill(['status' => Order::PENDING_STATUS]);
    }
}
