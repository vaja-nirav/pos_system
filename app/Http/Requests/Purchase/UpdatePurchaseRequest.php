<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
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
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_no' => 'required|unique:purchases,invoice_no,' . $this->route('purchase'),
            'purchase_date' => 'required|date',
            'subtotal' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
            'payment_status' => 'required',
            'status' => 'required',
            // Products
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.cost_price' => 'required|numeric|min:0',
            'products.*.total' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            // Supplier
            'supplier_id.required' => 'Supplier is required.',
            'supplier_id.exists' => 'Selected supplier does not exist.',

            // Invoice
            'invoice_no.required' => 'Invoice number is required.',
            'invoice_no.unique' => 'Invoice number already exists.',

            // Date
            'purchase_date.required' => 'Purchase date is required.',
            'purchase_date.date' => 'Purchase date must be a valid date.',

            // Amounts
            'subtotal.required' => 'Subtotal is required.',
            'subtotal.numeric' => 'Subtotal must be a number.',

            'tax.numeric' => 'Tax must be a number.',

            'discount.numeric' => 'Discount must be a number.',

            'total.required' => 'Total is required.',
            'total.numeric' => 'Total must be a number.',

            'paid_amount.numeric' => 'Paid amount must be a number.',

            'due_amount.numeric' => 'Due amount must be a number.',

            // Status
            'payment_status.required' => 'Payment status is required.',
            'status.required' => 'Status is required.',

            // Products
            'products.required' => 'At least one product is required.',

            'products.*.product_id.required' => 'Product is required in each line.',
            'products.*.product_id.exists' => 'Selected product does not exist.',

            'products.*.quantity.required' => 'Quantity is required.',
            'products.*.quantity.integer' => 'Quantity must be an integer.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',

            'products.*.cost_price.required' => 'Cost price is required.',
            'products.*.cost_price.numeric' => 'Cost price must be a number.',
            'products.*.cost_price.min' => 'Cost price cannot be negative.',

            'products.*.total.required' => 'Total is required.',
            'products.*.total.numeric' => 'Total must be a number.',
            'products.*.total.min' => 'Total cannot be negative.',
        ];
    }
}
