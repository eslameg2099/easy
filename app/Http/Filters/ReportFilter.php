<?php

namespace App\Http\Filters;

class ReportFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'selected_id',
        'status',
        'shop_order_id',
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

    public function shopOrderId($value)
    {
        if ($value) {
            return $this->builder->where('shop_order_id', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given status.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($value)
    {
        if ($value == 'read') {
            return $this->builder->whereNotNull('read_at');
        }
        if ($value == 'unread') {
            return $this->builder->whereNull('read_at');
        }

        return $this->builder;
    }
}
