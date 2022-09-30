<?php

namespace App\Http\Resources;

use App\Support\Date;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectResource extends JsonResource
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
            'amount' => price($this->amount),
            'date' => new Date($this->date),
        ];
    }
}
