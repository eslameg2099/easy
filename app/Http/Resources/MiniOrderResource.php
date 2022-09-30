<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Support\Date;
use Illuminate\Http\Resources\Json\JsonResource;

class MiniOrderResource extends JsonResource
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
            'address' => new AddressResource($this->address),
            'user' => new MiniUserResource($this->user),
            'payment_method' => $payment = (int) $this->payment_method ?: Order::CASH_PAYMENT,
            'readable_payment_method' => (string) trans('orders.payments.'.$payment),
        ];
    }
}
