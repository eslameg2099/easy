<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use App\Models\ShopOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can accept the order.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function accept(User $user, ShopOrder $order)
    {
        return $user->is($order->shop->owner) && $order->status == Order::PENDING_STATUS;
    }

    /**
     * Determine whether the user can mark the order as waiting deliver.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function markAsWaitingDeliver(User $user, ShopOrder $order)
    {
        return $user->is($order->shop->owner) && $order->status == Order::IN_PROGRESS_STATUS;
    }

    /**
     * Determine whether the user can mark the order as assigned to delegate.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function markAsAssignedToDelegate(User $user, ShopOrder $order)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.orders')) && $order->status == Order::WAITING_DELIVER_STATUS;
    }

    /**
     * Determine whether the user can mark the order as delivering to delegate.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function markAsDeliveringToDelegate(User $user, ShopOrder $order)
    {
        return $user->is($order->delegate) && $order->status == Order::ASSIGNED_TO_DELEGATE_STATUS;
    }

    /**
     * Determine whether the user can mark the order as delivered to delegate.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function markAsDeliveredToDelegate(User $user, ShopOrder $order)
    {
        return $user->is($order->shop->owner) && $order->status == Order::DELIVERING_TO_DELEGATE;
    }

    /**
     * Determine whether the user can mark the order as delivering.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function markAsDelivering(User $user, ShopOrder $order)
    {
        return $user->is($order->delegate) && $order->status == Order::DELIVERED_TO_DELEGATE;
    }

    /**
     * Determine whether the user can mark the order as delivered.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function markAsDelivered(User $user, ShopOrder $order)
    {
        return $user->is($order->delegate) && $order->status == Order::DELIVERING_STATUS;
    }

    /**
     * Determine whether the user can report the order.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\ShopOrder $order
     * @return mixed
     */
    public function report(User $user, ShopOrder $order)
    {
        return $user->is($order->delegate)
            || $user->is($order->order->user)
            || $user->is($order->shop->owner);
    }
}
