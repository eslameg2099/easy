<?php

namespace App\Http\Filters;

use App\Models\Order;
use App\Models\User;

class UserFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'type',
        'available_delegates',
        'email',
        'selected_id',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->where('name', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query to include users by type.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($value)
    {
        if ($value) {
            return $this->builder->where('type', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query to include users by email.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function email($value)
    {
        if ($value) {
            return $this->builder->where('email', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query to include users by delegate.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function availableDelegates($value)
    {
        if ($value) {
            return $this->builder->where('type', User::DELEGATE_TYPE)->where('city_id',2)
                ->whereDoesntHave('delegateShopOrders', function ($builder) {
                    $builder->whereIn('status', [
                        Order::DELIVERING_TO_DELEGATE,
                        Order::DELIVERING_STATUS,
                        Order::DELIVERED_TO_DELEGATE,
                    ]);
                });
        }

        return $this->builder;
    }

    /**
     * Sorting results by the given id.
     *
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function selectedId($value)
    {
        if ($value) {
            $this->builder->sortingByIds($value);
        }

        return $this->builder;
    }
}
