<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'cities' => CityResource::collection($this->cities),
            'address' => $this->address,
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
        ];
    }
}
