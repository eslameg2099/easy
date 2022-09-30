<?php

namespace App\Http\Resources;

use App\Support\Date;
use App\Support\Price;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed offer_price
 * @property mixed price
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'locked' => $this->locked(),
            'is_favorited' => $this->isFavorited(),
            'image' => new MediaResource($this->getFirstMedia()),
            'images' => MediaResource::collection($this->getMedia()),
            'shop' => new ShopResource($this->shop),
            'categories' => CategoryResource::collection($this->categories),
            'price' => new Price($this->price),
            'has_discount' => $this->offer_price > 0,
            'offer_price' => $this->when($this->offer_price, new Price($this->offer_price)),
            'discount_percentage' => $this->when($this->getDiscountPercentage(), $this->getDiscountPercentage()),
            'quantity' => $this->quantity,
            'rate' => (float) $this->rate,
            'rates_count' => count_formatted($this->reviews()->count()),
            'colors' => $this->colors,
            'sizes' => $this->sizes,
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'created_at' => new Date($this->created_at),
        ];
    }

    /**
     * Get the discount percentage.
     *
     * @return float|int|void
     */
    protected function getDiscountPercentage()
    {
        if (! $this->offer_price) {
            return;
        }

        return round($this->offer_price / $this->price * 100) . ' %';
    }
}
