<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoriesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return 
        [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'category_name' => $this->category?->name,
            'image' => $this->whenLoaded('images' , fn () => $this->images()->latest()->first('image'))?->image,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i a')
        ];
    }
}
