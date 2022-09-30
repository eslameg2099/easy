<?php

namespace App\Http\Filters;

class ShopFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'category_id',
        'selected_id',
        'category_name',
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
     * Filter the query by a given category.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function categoryId($value)
    {
        if ($value) {
            return $this->builder->where('category_id', $value);
        }

        return $this->builder;
    }

    protected function categoryName($value)
    {
        if ($value) {
            return $this->builder->whereHas('category', function ($builder) use ($value) {
                $builder->whereTranslationLike('name', "%$value%");
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
