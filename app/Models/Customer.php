<?php

namespace App\Models;

use Parental\HasParent;
use App\Http\Filters\CustomerFilter;
use App\Http\Resources\CustomerResource;
use App\Models\Relations\CustomerRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends User
{
    use HasFactory;
    use HasParent;
    use CustomerRelations;
    use SoftDeletes;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = CustomerFilter::class;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return User::class;
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_id';
    }

    /**
     * @return \App\Http\Resources\CustomerResource
     */
    public function getResource()
    {
        return new CustomerResource($this);
    }

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return route('dashboard.customers.show', $this);
    }

    /**
     * Get the readable status for customers.
     *
     * @param $status
     * @return string
     */
    public function getReadableStatus($status)
    {
        switch ($status) {
            case Order::PENDING_STATUS:
            case Order::IN_PROGRESS_STATUS:
            case Order::WAITING_DELIVER_STATUS:
            case Order::ASSIGNED_TO_DELEGATE_STATUS:
            case Order::DELIVERING_TO_DELEGATE:
            case Order::DELIVERED_TO_DELEGATE:
                return trans('orders.statuses.'.Order::IN_PROGRESS_STATUS);
            case Order::DELIVERING_STATUS:
                return trans('orders.statuses.'.Order::DELIVERING_STATUS);
            case Order::DELIVERED_STATUS:
                return trans('orders.statuses.'.Order::DELIVERED_STATUS);
        }
    }
}
