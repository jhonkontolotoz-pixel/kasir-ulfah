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
        'title'       => 'required|string|min:3|max:100',
        'description' => 'nullable|string|min:5',
        'price'       => 'required|numeric|min:0',
        'quantity'    => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image'       => 'nullable|mimes:png,jpg,jpeg|max:2048',
    ];
}

}
