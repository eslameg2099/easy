<?php

namespace App\Http\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'shop_id',
        'category_id',
        'category_name',
        'shop_name',
        'has_discount',
        'sort',
        'selected_id',
        'price',
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
     * Filter the query by discount.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function hasDiscount($value)
    {
        if ($value) {
            return $this->builder->where('has_discount', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by shop.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function shopId($value)
    {
        if ($value) {
            return $this->builder->where('shop_id', $value);
        }

        return $this->builder;
    }

    protected function shopName($value)
    {
       

        if ($value) {
            return $this->builder->whereHas('shop', function (Builder $builder) use ($value) {
                $builder->where('name', 'like', "%$value%");
            });
            }

        return $this->builder;
    }
    

    /**
     * Filter the query by price.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function price($value)
    {
        if ($value) {
            $price = explode('-', $value);

            $from = $price[0] ?? 0;

            $to = $price[1] ?? Product::max('price');

            return $this->builder->whereBetween('offer_price', [$from, $to])->orWhereBetween('price', [$from, $to]);
        }

        return $this->builder;
    }

    /**
     * Filter the query by discount.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function sort($value)
    {
        switch ($value) {
            case 'latest':
                $this->builder->latest();
                break;
            case 'latest_price':
                $this->builder->latest('price');
                break;
            case 'oldest_price':
                $this->builder->oldest('price');
                break;
            case 'oldest':
                $this->builder->oldest();
                break;
            case 'most_seller':
                $this->builder->mostSeller();
                break;
            case 'offers':
                $this->builder->offersFirst();
                break;
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
            return $this->builder->whereHas('categories', function (Builder $builder) use ($value) {
                $builder->where('category_id', $value);
            });
        }

        return $this->builder;
    }

    protected function categoryName($value)
    {
        if ($value) {
            return $this->builder->whereHas('category', function (Builder $builder) use ($value) {
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
