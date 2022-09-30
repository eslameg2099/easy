<?php

namespace App\Models\Presenters;

use App\Models\Order;
use Laracasts\Presenter\Presenter;

class OrderPresenter extends Presenter
{
    /**
     * Display the readable status.
     *
     * @return string
     */
    public function status()
    {
        if (auth()->check()) {
            return auth()->user()->getReadableStatus($this->entity->status);
        }

        return trans('orders.statuses.'.$this->entity->status);
    }

    /**
     * Display the readable payment.
     *
     * @return string
     */
    public function payment()
    {
        return trans('orders.payments.'.$this->entity->payment_method);
    }

    /**
     * Get the status color.
     *
     * @return string
     */
    public function statusColor()
    {
        switch ($this->entity->status) {
            case Order::PENDING_STATUS:
                $color = '#F4B71E';
                break;
            case Order::IN_PROGRESS_STATUS:
            case Order::WAITING_DELIVER_STATUS:
            case Order::ASSIGNED_TO_DELEGATE_STATUS:
            case Order::DELIVERED_TO_DELEGATE:
            case Order::DELIVERING_TO_DELEGATE:
            case Order::DELIVERING_STATUS:
                $color = '#143068';
                break;
            case Order::DELIVERED_STATUS:
                $color = '#5FAE2E';
                break;
        }

        return $color;
    }
}
