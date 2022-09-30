<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ShopOrderFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presenters\OrderPresenter;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method OrderPresenter present()
 */
class ShopOrder extends Model
{
    use HasFactory;
    use Filterable;
    use PresentableTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sub_total',
        'shop_id',
        'status',
        'discount',
        'shipping_cost',
        'profit_system',
        'profit_shop',
        'tax',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'collected_at' => 'datetime',
        'delegate_collected_at' => 'datetime',
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = ShopOrderFilter::class;

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = OrderPresenter::class;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'delegate',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $withCount = [
        'items',
    ];

    /**
     * Retrieve the order instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }

    /**
     * Retrieve the shop instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class)->withTrashed();
    }

    /**
     * Get the order's items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ShopOrderProduct::class);
    }

    /**
     * Retrieve the delegate instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delegate()
    {
        return $this->belongsTo(Delegate::class)->withTrashed();
    }

    /**
     * Get all the order's reports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'shop_order_id');
    }
}
