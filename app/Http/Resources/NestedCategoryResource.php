<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NestedCategoryResource extends JsonResource
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
            'has_children' => ! ! $this->children_count,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
