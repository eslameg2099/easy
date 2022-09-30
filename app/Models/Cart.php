<?php

namespace App\Models;

use App\Support\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\AddressResource;
use Laraeast\LaravelSettings\Facades\Settings;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'identifier',
        'user_id',
        'payment_method',
        'shipping_cost_user',
        'shipping_cost_shop',
        'tax_total',
    ];

    /**
     * Get the cart user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the cart address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get all the cart items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
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
            'identifier' => $this->identifier,
            'payment_method' => (int) $this->payment_method,
            'readable_payment_method' => ! is_null($this->payment_method)
                ? trans('orders.payments.'.$this->payment_method)
                : null,
            'notes' => $this->notes,
            'address' => $this->address ? new AddressResource($this->address) : null,
            'sub_total' => new Price($this->sub_total),
            'shipping_cost' => new Price($this->shipping_cost_user + $this->shipping_cost_shop ),
            'discount' => new Price($this->discount),
            'total' => new Price(($this->sub_total + $this->shipping_cost_shop + (($this->sub_total * Settings::get('added') ) /100))- $this->discount),
            'profit_system' => new Price($this->items->sum('tax')),
            'value_added_tax'=> (int) Settings::get('added'),
            'items' => $this->items,
        ];
    }
}
