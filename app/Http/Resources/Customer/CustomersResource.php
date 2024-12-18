<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Order\OrdersCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CustomersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'orders_count' => $this->orders_count,
            'orders' => $this->whenLoaded('orders',fn () => new OrdersCollection($this->orders)),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i a')
        ];
    }
}
