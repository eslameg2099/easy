<?php

namespace App\Support\Cart;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Str;
use App\Support\Cart\Events\ItemAdded;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;

class CartServices
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var \App\Models\Cart
     */
    protected $cart;

    /**
     * @var \App\Models\CartItem[]|\Illuminate\Database\Eloquent\Collection
     */
    protected $items;

    /**
     * @var \App\Models\User|null
     */
    protected $user;

    /**
     * @var array
     */
    protected $cartData = [];

    /**
     * CartServices constructor.
     *
     * @param null $identifier
     * @param \App\Models\User|null $user
     */
    public function __construct($identifier = null, User $user = null)
    {
        $this->cartData['identifier'] = $identifier;

        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        if (empty($this->cartData['identifier'])) {
            $this->setIdentifier(Str::uuid());
        }

        return $this->cartData['identifier'];
    }

    /**
     * @param mixed $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->cartData['identifier'] = $identifier;

        return $this;
    }

    /**
     * @param $paymentMethod
     * @return $this
     */
    public function paymentMethod($paymentMethod)
    {
        $this->cartData['payment_method'] = $paymentMethod;

        return $this;
    }

    /**
     * @param $shippingCost
     * @return $this
     */
    public function shippingCost($shippingCost)
    {
        $this->cartData['shipping_cost'] = $shippingCost;

        return $this;
    }

    /**
     * @return \App\Models\Cart
     */
    public function getCart()
    {
        $cart = $this->getCartViaUser() ?: $this->getCartViaIdentifier();
        $cart = $cart ?: $this
            ->createCartForIdentifier()
            ->getCartViaIdentifier();

        $this->refreshItems();

        return $cart;
    }

    /**
     * @return $this
     */
    public function assignUserToCart(User $user = null)
    {
        $cart = $this->getCart();

        if (! $cart->user) {
            $cart->update(['user_id', $user->id ?? null]);
        }

        return $this;
    }

    /**
     * @return \App\Models\Cart|void|null
     */
    public function getCartViaUser()
    {
        if (! $this->getUser()) {
            return;
        }

        return $this->cart = Cart::where('user_id', $this->getUser()->id)->first();
    }

    /**
     * @return \App\Models\Cart|null
     */
    public function getCartViaIdentifier()
    {
        return $this->cart = Cart::where('identifier', $this->getIdentifier())->first();
    }

    /**
     * @return $this
     */
    public function createCartForIdentifier()
    {
        if ($user = $this->getUser()) {
            $this->cartData['user_id'] = $user->id;
        }

        $this->cart = Cart::create($this->cartData);

        return $this;
    }

    /**
     * @return $this
     */
    public function refreshItems()
    {
        $this->items = $this->cart->items()->get();

        return $this;
    }

    public function shipping($new_item)
    {
        $cart = $this->getCart();
      
        if($cart->whereDoesntHave('items')->get())
        {
            $shipping_cost  = $new_item->product->shop->owner->city->shipping_cost;
            $cart->forceFill([
                'shipping_cost_shop' =>  $shipping_cost 
                ,
            ])->save();
        }
        else

        foreach($cart->whereHave('items')->get() as $item)
        {
           if( $item->product->shop->owner->id != $new_item->product->shop->owner->id )
           {
            $shipping_cost  =  $cart->shipping_cost_shop  +  $new_item->product->shop->owner->city->shipping_cost;
            $cart->forceFill([
                'shipping_cost_shop' =>   $shipping_cost
                ,
            ])->save();
           }
        }
        $this->cart = $cart;
        return $this;

    }

    /**
     * @return $this
     */
    public function updateTotals()
    {
        $cart = $this->getCart();

        $cart->forceFill([
            'sub_total' => $cart->items->map(function (CartItem $item) {
                return $item->price * $item->quantity;
            })->sum(),
            'tax_total' => $cart->items->sum('tax')
            ,
            
        ])->save();
        $this->cart = $cart;

        return $this;
    }

    /**
     * @return \App\Models\CartItem[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     * @return $this
     */
    public function addItem($productId, int $quantity = 1, $color = [], $size = [],$tax)
    {
        // Ensure that the given product id is the key of product.
        if ($productId instanceof Product) {
            $productId = $productId->id;
        }

        // Ensure that the given product is exists.
        if (! $product = Product::find($productId)) {
            
            throw ValidationException::withMessages([
                'quantity' => __('The requested product is not found.'),
            ]);
        }

        // Ensure that the requested quantity is available.
        if ($product->quantity < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => __('The requested quantity is not available.'),
            ]);
        }

        // Ensure that the requested color is available.
        $colors = collect($product->colors);

        if ($colors->isNotEmpty() && empty($color)) {
            throw ValidationException::withMessages([
                'color' => __('The color is required.'),
            ]);
        }

        if (
            $colors->isNotEmpty() &&
            ($colors->where('name', data_get($color, 'name'))->isEmpty() ||
                $colors->where('hex', data_get($color, 'hex'))->isEmpty())
        ) {
            throw ValidationException::withMessages([
                'color' => __('The requested color is not available.'),
            ]);
        }

        // Ensure that the requested size is available.
        $sizes = collect($product->sizes);

        if ($sizes->isNotEmpty() && empty($size)) {
            throw ValidationException::withMessages([
                'size' => __('The size is required.'),
            ]);
        }

        if (
            $sizes->isNotEmpty() &&
            $sizes->where('size', data_get($size, 'size'))->isEmpty()
        ) {
            throw ValidationException::withMessages([
                'size' => __('The requested size is not available.'),
            ]);
        }

        // Now we check if the item is already exists with the same color ans size
        // We update it's quantity
        // Otherwise we create a new item.

        $item = $this
            ->getCart()
            ->items()
            ->where('product_id', $product->id)
            ->whereJsonContains('color->name', data_get($color, 'name'))
            ->whereJsonContains('color->hex', data_get($color, 'hex'))
            ->whereJsonContains('size->size', data_get($size, 'size'))
            ->first();

        if (!$item) {
            $item = $this->getCart()->items()->create([
                'product_id' => $product->id,
                'price' => $product->getPrice(),
                'quantity' => $quantity,
                'color' => $color,
                'size' => $size,
                'tax'=>$tax,
            ]);
            if($this->getCart()->items()->count() == 1)
            {
                $item->shipping = '1';
                $item->save();
            }
            else {
                # code...
                foreach($this->getCart()->items()->get() as $iteem)
                {
                   if($iteem->product->shop->owner->id != $item->product->shop->owner->id )
                   {
                    $item->shipping = '1';
                    $item->save();
                   }
                }
            }
           

        } else {
            // Ensure that the requested quantity is available.
            $newQuantity = $item->quantity + $quantity;
            if ($product->quantity < $newQuantity) {
                throw ValidationException::withMessages([
                    'quantity' => __('The requested quantity is not available.'),
                ]);
            }
            $item->update([
                'quantity' => $newQuantity,
            ]);
        }

        // Update the cart items.
        $this->refreshItems();
       // $this->shipping($item);
        $this->updateTotals();
        
        // Fire an event to handle real-time.
        broadcast(new ItemAdded($item))->toOthers();

        return $this;
    }

    /**
     * @return \App\Models\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \App\Models\User|null $user
     * @return \App\Support\Cart\CartServices
     */
    public function setUser(?User $user)
    {
        $this->user = $user;

        return $this;
    }
}
