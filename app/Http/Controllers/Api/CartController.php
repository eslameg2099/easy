<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Support\Cart\CartServices;
use App\Http\Controllers\Controller;
use App\Support\Cart\Events\ItemDeleted;
use App\Support\Cart\Events\ItemUpdated;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;
use App\Models\UserCoupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Address;

class CartController extends Controller
{
    public function get()
    {
        request()->validate([
            'payment_method' => 'numeric|in:0,1',
        ]);

        $cartServices = app(CartServices::class);

        return $cartServices
            ->setUser(auth()->user())
            ->setIdentifier(request()->header('cart-identifier'))
            ->paymentMethod(request()->payment_method)
            ->shippingCost(request()->shipping_cost)
            ->getCart();
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0',
        ]);
      
        $cartServices = app(CartServices::class);

        $cartServices
            ->setUser(auth()->user())
            ->setIdentifier($request->header('cart-identifier'));

        $cartServices->addItem(
            $request->product_id,
            $request->quantity,
            $request->input('color', []),
            $request->input('size', []),
            $tax = $this->tax_product($request->product_id),

        );

        return $cartServices->getCart();
    }

    public function updateItem(CartItem $cartItem, Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $cartItem->update($request->only('quantity'));

        $cartServices = app(CartServices::class);

        $cart = $cartServices
            ->setUser(auth()->user())
            ->setIdentifier($request->header('cart-identifier'))
            ->getCart();

        $cartServices->updateTotals();

        broadcast(new ItemUpdated($cartItem))->toOthers();

        return $cart->refresh();
    }

    public function deleteItem(CartItem $cartItem, Request $request)
    {
        $cartItem->delete();

        $cartServices = app(CartServices::class);

        $cart = $cartServices
            ->setUser(auth()->user())
            ->setIdentifier($request->header('cart-identifier'))
            ->getCart();

        $cartServices->updateTotals();

        broadcast(new ItemDeleted($cart->refresh()))->toOthers();

        return $cart;
    }

    public function update(Request $request)
    {
        $request->validate([
            'address_id' => 'exists:addresses,id',
        ]);

        $cartServices = app(CartServices::class);

        $cart = $cartServices
            ->setUser(auth()->user())
            ->setIdentifier($request->header('cart-identifier'))
            ->getCart();

        if ($value = $request->input('payment_method')) {
            $cart->forceFill(['payment_method' => $value]);
        }

        if ($value = $request->input('address_id')) {
            $cart->forceFill(['address_id' => $value]);
            $cart->save();
            $shipping_cost = 0;
            $defalut_shipping_cost =  Settings::get('shipping_cost');

        foreach($cart->items()->where('shipping','1')->get() as $item)
        {
                        //set free_shipping
            if($item->product->shop->free_shipping == '1')
            {
                $shipping_cost = $shipping_cost + 0;
                $item->z=0;
                $item->save();


            }

            else
            //set deflaut 

            if($item->product->shop->owner->cities()->count() != $cart->address->cities()->count() )
            {
             $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
             $item->z=$defalut_shipping_cost;
             $item->save();


            }
            
                
            else

           if($item->product->shop->owner->cities()->count() == 4)
           {

             if($item->product->shop->owner->cities[3]->id == $cart->address->cities[3]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[3]->shipping_cost;
                   $item->z=$item->product->shop->owner->cities[3]->shipping_cost;
                   $item->save();
                    
             }
             elseif($item->product->shop->owner->cities[2]->id == $cart->address->cities[2]->id)
                    {
                        
                       $shipping_cost  =  $shipping_cost   +  $item->product->shop->owner->cities[2]->shipping_cost;
                       $item->z=$item->product->shop->owner->cities[2]->shipping_cost;
                       $item->save();
                        
                           
                    }
                 else if($item->product->shop->owner->cities[1]->id == $cart->address->cities[1]->id)
                    {

                        $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[1]->shipping_cost;
                        $item->z=$item->product->shop->owner->cities[1]->shipping_cost;
                        $item->save();
                         
                         
                    }
                    elseif($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
                    {
                       
                        $shipping_cost  = $shipping_cost  + $item->product->shop->owner->cities[0]->shipping_cost;
                        $item->z=$item->product->shop->owner->cities[0]->shipping_cost;
                        $item->save();
                         
                            
                       
                    }
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                        $item->z= $defalut_shipping_cost;
                        $item->save();
                         
                            
                      
                    }

           }

           if($item->product->shop->owner->cities()->count() == 3)
           {
               
             if($item->product->shop->owner->cities[2]->id == $cart->address->cities[2]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[2]->shipping_cost;
                   $item->z= $item->product->shop->owner->cities[2]->shipping_cost;
                   $item->save();
                    
             }
             elseif($item->product->shop->owner->cities[1]->id == $cart->address->cities[1]->id)
                    {
                        
                       $shipping_cost  =  $shipping_cost   +  $item->product->shop->owner->cities[1]->shipping_cost;
                       $item->z= $item->product->shop->owner->cities[1]->shipping_cost;
                       $item->save();
                        
                           
                    }
               
                    elseif($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
                    {
                       
                        $shipping_cost  = $shipping_cost  + $item->product->shop->owner->cities[0]->shipping_cost;
                        $item->z= $item->product->shop->owner->cities[0]->shipping_cost;
                        $item->save();
                         
                       
                    }
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                        $item->z= $defalut_shipping_cost;
                        $item->save();
                         
                            
                      
                    }

           }

           if($item->product->shop->owner->cities()->count() == 2)
           {
               
             if($item->product->shop->owner->cities[1]->id == $cart->address->cities[1]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[1]->shipping_cost;
                   $item->z= $item->product->shop->owner->cities[1]->shipping_cost;
                   $item->save();
                    
                    
             }
             elseif($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
                    {
                        
                       $shipping_cost  =  $shipping_cost   +  $item->product->shop->owner->cities[0]->shipping_cost;
                       $item->z= $item->product->shop->owner->cities[0]->shipping_cost;
                       $item->save();
                    }
               
                 
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                        $item->z= $defalut_shipping_cost;
                        $item->save();
                            
                      
                    }

           }
           if($item->product->shop->owner->cities()->count() == 1)
           {
               
             if($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[0]->shipping_cost;
                   $item->z= $item->product->shop->owner->cities[0]->shipping_cost;
                   $item->save();
                    
             }
           
               
                 
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                        $item->z= $defalut_shipping_cost;
                        $item->save();
                            
                      
                    }


           }
            

            
                   
               
            

        }
        $cart->forceFill([
         'shipping_cost_shop' => $shipping_cost 
         ,
     ])->save();
        
    }
          //  $this->shipping($cart);
           
           
            
        

        if ($value = $request->input('notes')) {
            $cart->forceFill(['notes' => $value]);
        }

        if ($value = $request->input('coupon')) {
            $this->applyCoupon($value, $cart);
        }

        $cart->save();

        return $cart;
    }

    protected function applyCoupon($coupon, Cart &$cart)
    {
        /** @var \App\Models\Coupon $coupon */
        
        if (! $coupon = Coupon::where('code', $coupon)->first()) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is invalid.')],
            ]);
        }

        if ($coupon->isExpired()) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is expired.')],
            ]);
        }

        if ($coupon->used >= $coupon->usage_count) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is used.')],
            ]);
        }

        if ( $UserCoupon = UserCoupon::where('coupon_id',$coupon->id)->where('user_id',auth()->user()->id)->first() ) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon use one only.')],
            ]);
        }
        
        $discount = $cart->items->sum('tax') / 100 * $coupon->percentage_value;

        $cart->forceFill(['discount' => $discount]);
        $cart->forceFill(['discount_percentage' => $coupon->percentage_value]);
        $cart->forceFill(['coupon_id' => $coupon->id]);
       
        return $this;
    }


    public function reorder(Request $request)
    {
        $request->validate([
            'id' => 'exists:orders,id',
        ]);
        $cartServices = app(CartServices::class);

         $cartServices
            ->setUser(auth()->user())
           
            ->getCart();
        $Order = Order::findorfail($request->id);
        foreach($Order->shopOrders()->get() as $item)
        {
            foreach($item->items()->get() as $shop)
            {
                $cartServices->addItem(
                    $shop->product_id,
                    $shop->quantity,
                    $shop->color,
                    $shop->size,
                    $tax = $this->tax_product($shop->product_id),

                );


            }
         
        }

        return $cartServices->getCart();
    }


    public function tax_product($id)
    {
        $product = Product::findorfail($id);
        if($product->getPrice() <= 20 )
        {
            return  $product_tax = (($product->getPrice() * Settings::get('commission_level_1'))/100);

        }

       elseif($product->getPrice() <= 60 && $product->getPrice() >= 21)
        {
            return  $product_tax = (($product->getPrice() * Settings::get('commission_level_2'))/100);
        }
        elseif($product->getPrice() <= 100 && $product->getPrice() >= 61)
        {
            return  $product_tax = (($product->getPrice() * Settings::get('commission_level_3'))/100);

        }
        else
        {
            return  $product_tax = (($product->getPrice() * Settings::get('commission_level_4'))/100);

        }

    }


    public function shipping(Cart $cart)
    {
        
        $shipping_cost = 0;
        $defalut_shipping_cost =  Settings::get('shipping_cost');

        foreach($cart->items()->get() as $item)
        {
            //set deflaut 
            if($item->product->shop->free_shipping == '1')
            {
                $shipping_cost = $shipping_cost + 0;
            }

            else

            if($item->product->shop->owner->cities()->count() != $cart->address->cities()->count() )
            {
             $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;

            }
            else 
                
            
           if($item->product->shop->owner->cities()->count() == 4)
           {
             if($item->product->shop->owner->cities[3]->id == $cart->address->cities[3]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[2]->shipping_cost;
                    
             }
             elseif($item->product->shop->owner->cities[2]->id == $cart->address->cities[2]->id)
                    {
                        
                       $shipping_cost  =  $shipping_cost   +  $item->product->shop->owner->cities[1]->shipping_cost;
                           
                    }
                 else if($item->product->shop->owner->cities[1]->id == $cart->address->cities[1]->id)
                    {

                        $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[0]->shipping_cost;
                         
                    }
                    elseif($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
                    {
                       
                        $shipping_cost  = $shipping_cost  + $item->product->shop->owner->cities[0]->shipping_cost;
                            
                       
                    }
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                            
                      
                    }

           }

           if($item->product->shop->owner->cities()->count() == 3)
           {
             if($item->product->shop->owner->cities[2]->id == $cart->address->cities[2]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[1]->shipping_cost;
                    
             }
             elseif($item->product->shop->owner->cities[1]->id == $cart->address->cities[1]->id)
                    {
                        
                       $shipping_cost  =  $shipping_cost   +  $item->product->shop->owner->cities[0]->shipping_cost;
                           
                    }
               
                    elseif($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
                    {
                       
                        $shipping_cost  = $shipping_cost  + $item->product->shop->owner->cities[0]->shipping_cost;
                            
                       
                    }
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                            
                      
                    }

           }

           if($item->product->shop->owner->cities()->count() == 2)
           {
             if($item->product->shop->owner->cities[1]->id == $cart->address->cities[1]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[0]->shipping_cost;
                    
             }
             elseif($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
                    {
                        
                       $shipping_cost  =  $shipping_cost   +  $item->product->shop->owner->cities[0]->shipping_cost;
                           
                    }
               
                 
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                            
                      
                    }

           }
           if($item->product->shop->owner->cities()->count() == 1)
           {
             if($item->product->shop->owner->cities[0]->id == $cart->address->cities[0]->id)
             {
              
                   $shipping_cost  = $shipping_cost + $item->product->shop->owner->cities[0]->shipping_cost;
                    
             }
           
               
                 
                    else {

                       
                        $shipping_cost  = $shipping_cost +  $defalut_shipping_cost;
                            
                      
                    }


           }
            

            
                   
               
            

        }
        $cart->forceFill([
         'shipping_cost_shop' => $shipping_cost 
         ,
     ])->save();
        
    }
}
