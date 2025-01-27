<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TopProductsResource extends JsonResource
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
            'title' =>$this->title,
            'sold_count' => $this->sold_count,
            'image' => $this->whenLoaded('images' , fn () => $this->images()->latest()->first('image'))?->image,
        ];
    }
}
