<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\OrderFilter;
use App\Support\Traits\Selectable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopOrderProduct extends Model
{
    use HasFactory;
    use Filterable;
    use Selectable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'color',
        'size',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'color' => 'array',
        'size' => 'array',
    ];

    /**
     * Retrieve the shop order instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shopOrder()
    {
        return $this->belongsTo(ShopOrder::class)->withTrashed();
    }

    /**
     * Retrieve the product instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
