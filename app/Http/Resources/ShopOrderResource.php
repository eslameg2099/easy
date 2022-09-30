<?php

namespace App\Http\Resources;

use App\Support\Date;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ShopOrder */
class ShopOrderResource extends JsonResource
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
            'status' => $this->status,
            'readable_status' => $this->present()->status,
            'status_color' => $this->present()->statusColor,
            'shop' => new ShopResource($this->shop),
            'order' => new MiniOrderResource($this->whenLoaded('order')),
            'delegate' => new DelegateResource($this->whenLoaded('delegate')),
            'sub_total' => price($this->sub_total),
            'discount' => price($this->discount),
            'shipping_cost' => price($this->shipping_cost),
            'total' => price($this->total),
            'tax' => price($this->tax),
            'profit_system' => price($this->profit_system),
            'profit_shop' => price($this->profit_shop),
            'create_at' => new Date($this->created_at),
            'items_count' => (int) $this->items_count,
            'phones' => [
                'user_phone' => $this->order->user->phone,
                'delegate_phone' => optional($this->delegate)->phone,
                'shop_phone' => $this->shop->owner->phone,
            ],
            'items' => ShopOrderProductResource::collection($this->whenLoaded('items')),
        ];
    }
}
