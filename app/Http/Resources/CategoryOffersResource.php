<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryOffersResource extends JsonResource
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
            'banner' => MediaResource::collection($this->getMedia('banner')),
            'label' => trans('categories.products', ['category' => $this->name]),
            'offers' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
