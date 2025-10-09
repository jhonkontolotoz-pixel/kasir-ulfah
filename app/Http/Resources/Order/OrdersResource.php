<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrdersResource extends JsonResource
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
            'code' => $this->code,
            'customer_name' => $this->whenLoaded('customer',fn () => $this->customer->name),
            'created_by' =>  $this->whenLoaded('user',fn () => $this->user->name),
            'total' => '$'.$this->total_price,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'products_count' => $this->orderItems->map(fn($item) => $item->quantity)->sum(),
            'created_at' => Carbon::parse($this->created_at)->format("Y-m-d h:i a"),
            'shipped_at' => $this->status == "shipped" ? Carbon::parse($this->updated_at)->format("Y-m-d h:i a") : '...',
            'delivered_at' => $this->status == "delivered" ? Carbon::parse($this->updated_at)->format("Y-m-d h:i a") : '...',
            'products' => $this->whenLoaded('products',fn () => new ProductCollection($this->products)),

        ];
    }
}
