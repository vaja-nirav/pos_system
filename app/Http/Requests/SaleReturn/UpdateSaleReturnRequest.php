<?php

namespace App\Http\Requests\SaleReturn;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'return_date'            => ['required', 'date'],
            'note'                   => ['nullable', 'string', 'max:500'],
            'products'               => ['required', 'array', 'min:1'],
            'products.*.product_id'  => ['required', 'exists:products,id'],
            'products.*.qty'         => ['required', 'integer', 'min:0'],
            'products.*.price'       => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.required'  => 'At least one product is required.',
            'products.*.qty.min' => 'Return quantity cannot be negative.',
            'products.*.price.min' => 'Price cannot be negative.',
        ];
    }
}
