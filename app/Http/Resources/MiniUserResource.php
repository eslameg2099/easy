<?php

namespace App\Http\Resources;

use App\Support\Date;
use Illuminate\Http\Resources\Json\JsonResource;

class MiniUserResource extends JsonResource
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
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}
