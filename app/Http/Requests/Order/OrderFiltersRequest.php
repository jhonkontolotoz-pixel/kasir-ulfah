<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderFiltersRequest extends FormRequest
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
            'status'         => 'nullable|string|in:shipped,delivered,pending,canceled',
            'payment_method' => 'nullable|string|in:cash,card',
            'customer_name'  => 'nullable|string',
            'code'           => 'nullable|string',
            'limit'          => 'nullable|integer',
            'sortBy'         => 'nullable|string|in:total_price,created_at',
            'order'          => 'nullable|string|in:desc,asc'
        ];
    }
}
