<?php

namespace App\Http\Resources;

use App\Support\Date;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'comment' => $this->comment,
            'rate' => (float) $this->rate,
            'reviewer' => new CustomerResource($this->reviewer),
            'created_at' => new Date($this->created_at),
        ];
    }
}
