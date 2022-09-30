<?php

namespace App\Http\Resources;

use App\Support\Date;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Delegate */
class DelegateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_verified' => ! ! $this->phone_verified_at,
            'type' => $this->type,
            'localed_type' => $this->present()->type,
            'avatar' => $this->getAvatar(),
            'cities' => CityResource::collection($this->cities),
            'national_id' => $this->national_id,
            'national_front_image' => new MediaResource($this->getFirstMedia('national_front_image')),
            'national_back_image' => new MediaResource($this->getFirstMedia('national_back_image')),
            'vehicle_type' => $this->vehicle_type,
            'vehicle_model' => $this->vehicle_model,
            'vehicle_image' => new MediaResource($this->getFirstMedia('vehicle_image')),
            'vehicle_number' => $this->vehicle_number,
            'is_available' => (bool) $this->is_available,
            'is_approved' => (bool) $this->is_approved,
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
            'created_at' => new Date($this->created_at),
        ];
    }
}
