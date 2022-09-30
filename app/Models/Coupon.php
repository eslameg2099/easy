<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\CouponFilter;
use App\Support\Traits\Selectable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    use Filterable;
    use Selectable;

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = CouponFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'percentage_value',
        'expired_at',
        'usage_count',
        'used',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Determine whither the coupon is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expired_at->isPast();
    }
}
