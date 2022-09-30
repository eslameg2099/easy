<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\OrderFilter;
use App\Support\Traits\Selectable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presenters\OrderPresenter;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method OrderPresenter present()
 */
class Order extends Model
{
    use HasFactory;
    use Filterable;
    use Selectable;
    use PresentableTrait;
    use SoftDeletes;

    /**
     * The code of pending status.
     *
     * @var int
     */
    const PENDING_STATUS = 1;

    /**
     * The code of pending status.
     *
     * @var int
     */
    const IN_PROGRESS_STATUS = 2;

    /**
     * The code of waiting deliver status.
     *
     * @var int
     */
    const WAITING_DELIVER_STATUS = 3;

    /**
     * The code of assigned to delegate status.
     *
     * @var int
     */
    const ASSIGNED_TO_DELEGATE_STATUS = 4;

    /**
     * The code of delivered to delegate status.
     *
     * @var int
     */
    const DELIVERING_TO_DELEGATE = 5;

    /**
     * The code of delivered to delegate status.
     *
     * @var int
     */
    const DELIVERED_TO_DELEGATE = 6;

    /**
     * The code of pending status.
     *
     * @var int
     */
    const DELIVERING_STATUS = 7;

    /**
     * The code of pending status.
     *
     * @var int
     */
    const DELIVERED_STATUS = 8;

    /**
     * The code of online payment.
     *
     * @var int
     */
    const ONLINE_PAYMENT = 0;

    /**
     * The code of cash payment.
     *
     * @var int
     */
    const CASH_PAYMENT = 1;

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = OrderFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_id',
        'sub_total',
        'discount',
        'notes',
        'shipping_cost',
        'payment_method',
        'System_tax',
    ];

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
        'shopOrders.items.product',
        'shopOrders.delegate',
        'user',
        'address',
    ];

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Retrieve the address instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class)->withTrashed();
    }

    /**
     * Get the shop orders that associated the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopOrders()
    {
        return $this->hasMany(ShopOrder::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * @return string
     */
    public function getReadableStatus()
    {
        if ($this->shopOrders()->where('status', '<', self::DELIVERED_STATUS)->exists()) {
            return trans('orders.status.in-progress');
        }

        return trans('orders.status.done');
    }

    public function getStatus()
    {
        if ($this->shopOrders()->where('status', '<', self::DELIVERED_STATUS)->exists()) {
            return 1;
        }

        return 0;
    }
}
