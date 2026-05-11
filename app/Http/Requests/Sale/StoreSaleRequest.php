<?php

namespace App\Http\Requests\Sale;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'subtotal' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'total' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'required|numeric',
            'payment_status' => 'required',
            'note' => 'nullable',
            // Products
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'price' => 'required|array',
            'price.*' => 'required|numeric|min:0',
            'subtotal_item' => 'required|array',
            'subtotal_item.*' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            // Customer
            'customer_id.exists' => 'Selected customer does not exist.',

            // Date
            'sale_date.required' => 'Sale date is required.',
            'sale_date.date' => 'Sale date must be a valid date.',

            // Amounts
            'subtotal.required' => 'Subtotal is required.',
            'subtotal.numeric' => 'Subtotal must be a number.',

            'discount.numeric' => 'Discount must be a number.',

            'tax.numeric' => 'Tax must be a number.',

            'total.required' => 'Total is required.',
            'total.numeric' => 'Total must be a number.',

            'paid_amount.required' => 'Paid amount is required.',
            'paid_amount.numeric' => 'Paid amount must be a number.',

            'due_amount.required' => 'Due amount is required.',
            'due_amount.numeric' => 'Due amount must be a number.',

            // Status
            'payment_status.required' => 'Payment status is required.',

            // Products
            'product_id.required' => 'At least one product is required.',

            'product_id.*.required' => 'Product is required in each line.',
            'product_id.*.exists' => 'Selected product does not exist.',

            'quantity.required' => 'Quantity is required.',
            'quantity.*.required' => 'Quantity is required.',
            'quantity.*.integer' => 'Quantity must be an integer.',
            'quantity.*.min' => 'Quantity must be at least 1.',

            'price.required' => 'Price is required.',
            'price.*.required' => 'Price is required.',
            'price.*.numeric' => 'Price must be a number.',
            'price.*.min' => 'Price cannot be negative.',

            'subtotal_item.required' => 'Subtotal is required.',
            'subtotal_item.*.required' => 'Subtotal is required.',
            'subtotal_item.*.numeric' => 'Subtotal must be a number.',
            'subtotal_item.*.min' => 'Subtotal cannot be negative.',
        ];
    }
}
