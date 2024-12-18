<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CategoriesResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'products_count' =>  $this->products_count ,
            'products' => $this->whenLoaded('products',fn () => new ProductCollection($this->products)),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i a')
        ];
    }
}
