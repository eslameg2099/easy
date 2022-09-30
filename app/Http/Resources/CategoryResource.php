<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'image' => $this->getFirstMediaUrl(),
            'banner' => MediaResource::collection($this->getMedia('banner')),
            'has_children' => $this->children()->exists(),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
