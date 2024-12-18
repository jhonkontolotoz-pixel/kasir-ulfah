<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => "required|min:10|max:100",
            'description' => "required|min:5|max:1000",
            'price' => "required|numeric",
            'quantity'=> "required|integer",
            'category_id' => "required|exists:categories,id",
            'image' => 'sometimes|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
