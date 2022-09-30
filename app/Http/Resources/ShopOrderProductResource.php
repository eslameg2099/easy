<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopOrderProductResource extends JsonResource
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
            'product' => new MiniProductResource($this->whenLoaded('product')),
            'quantity' => (int) $this->quantity,
            'color' => $this->color,
            'size' => $this->size,
            'price' => price($this->price),
            'total' => price($this->total),
        ];
    }
}
