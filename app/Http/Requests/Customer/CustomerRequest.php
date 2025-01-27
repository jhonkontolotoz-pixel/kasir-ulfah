<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'sometimes|string|max:30',
            'email' => 'sometimes|string|email|unique:customers,email|max:255',
            'phone' => 'sometimes|numeric',
            'address' => 'sometimes|string|min:5|max:30',
        ];
    }
}
