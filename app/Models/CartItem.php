<?php

namespace App\Models;

use App\Support\Price;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'price',
        'quantity',
        'color',
        'size',
        'tax',
        'shipping',
        'z',
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price' => new Price($this->price),
            'color' => $this->color,
            'size' => $this->size,
            'updated' => $this->wasUpdated(),
            'updated_message' => $this->getUpdateMessage(),
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'shop_name' => $this->product->shop->name,
                'image' => $this->product->getFirstMediaUrl(),
            ],
        ];
    }

    /**
     * @return bool
     */
    public function wasUpdated()
    {
        if ($this->product->trashed()) {
            return true;
        }

        return $this->quantity > $this->product->quantity
            || $this->price != $this->product->getPrice();
    }

    /**
     * @return bool
     */
    public function getUpdateMessage()
    {
        if ($this->product->trashed()) {
            return __('هذا المنتج غير متوفر حاليا');
        }
        if ($this->quantity > $this->product->quantity) {
            return __('الكمية المطلوبة غير متوفرة حاليا');
        }
        if ($this->price != $this->product->getPrice()) {
            return __('تم تحديث سعر المنتج');
        }
    }
}
