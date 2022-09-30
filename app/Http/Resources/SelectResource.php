<?php

namespace App\Http\Resources;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class SelectResource extends JsonResource
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
            'text' => $this->name,
            'image' => $this->image(),
            'count'=> User::where('id',$this->id)
            ->wherehas('delegateShopOrders', function ($q) {
                $q->where('created_at',now());
            })->count(),
        ];
    }
}
