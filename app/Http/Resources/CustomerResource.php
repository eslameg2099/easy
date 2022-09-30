<?php

namespace App\Http\Resources;

use App\Support\Date;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Customer */
class CustomerResource extends JsonResource
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
            'avatar' => $this->getAvatar(),
            'localed_type' => $this->present()->type,
            'cities' => CityResource::collection($this->cities),
            'created_at' => new Date($this->created_at),
        ];
    }
}
