<?php

namespace App\Http\Filters;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class ShopOrderFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'status',
        'tab',
        'today',
        'selected_id',
    ];

    /**
     * Filter the query by a given status.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($value)
    {
        if ($value) {
            return $this->builder->where('status', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given status.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function tab($value)
    {
        $statuses = [];

        switch ($value) {
            case 'new':
                $this->builder
                    ->when(auth()->check() && auth()->user()->isShopOwner(), function (Builder $builder) {
                        $builder->where('shop_id', auth()->user()->shop->id);
                        $builder->whereIn('status', [
                            Order::PENDING_STATUS,
                        ]);
                    })
                    ->when(auth()->check() && auth()->user()->isDelegate(), function (Builder $builder) {
                        $builder->where('delegate_id', auth()->id());
                        $builder->where('status', Order::ASSIGNED_TO_DELEGATE_STATUS);
                    });
                break;
            case 'working':
                $this->builder
                    ->when(auth()->check() && auth()->user()->isShopOwner(), function (Builder $builder) {
                        $builder->where('shop_id', auth()->user()->shop->id);
                        $builder->whereIn('status', [
                            Order::IN_PROGRESS_STATUS,
                            Order::WAITING_DELIVER_STATUS,
                            Order::ASSIGNED_TO_DELEGATE_STATUS,
                            Order::DELIVERING_TO_DELEGATE,
                            Order::DELIVERED_TO_DELEGATE,
                            Order::DELIVERING_STATUS,
                        ]);
                    })
                    ->when(auth()->check() && auth()->user()->isDelegate(), function (Builder $builder) {
                        $builder->where('delegate_id', auth()->id());
                        $builder->whereIn('status', [
                            Order::DELIVERING_TO_DELEGATE,
                            Order::DELIVERING_STATUS,
                            Order::DELIVERED_TO_DELEGATE,
                        ]);
                    });
                break;
            case 'done':
                $this->builder
                    ->when(auth()->check() && auth()->user()->isShopOwner(), function (Builder $builder) {
                        $builder->where('shop_id', auth()->user()->shop->id);
                        $builder->whereIn('status', [
                            Order::DELIVERED_STATUS,
                        ]);
                    })
                    ->when(auth()->check() && auth()->user()->isDelegate(), function (Builder $builder) {
                        $builder->where('delegate_id', auth()->id());
                        $builder->where('status', Order::DELIVERED_STATUS);
                    });
                break;
        }

        return $this->builder;
    }

    /**
     * Filter the query to include only orders created today.
     *
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function today($value)
    {
        if ($value) {
            $this->builder->whereDate('created_at', today());
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
