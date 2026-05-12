<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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

            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'barcode' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'cost_price' => 'required_if:product_type,single|nullable|numeric|min:0',
            'selling_price' => 'required_if:product_type,single|nullable|numeric|min:0',
            'stock_alert' => 'required_if:product_type,single|nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'opening_stock' => 'required_if:product_type,single|nullable|integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'product_type' => 'required|string|in:single,variation',
            'variation_id' => 'required_if:product_type,variation|nullable|exists:variations,id',
            'variations' => 'required_if:product_type,variation|nullable|array',
            'variations.*' => 'nullable|string',
            'variation_cost' => 'required_if:product_type,variation|nullable|array',
            'variation_price' => 'required_if:product_type,variation|nullable|array',
            'variation_sku' => 'required_if:product_type,variation|nullable|array',
            'variation_opening_stock' => 'required_if:product_type,variation|nullable|array',
            'variation_stock_alert' => 'required_if:product_type,variation|nullable|array',
        ];
    }

    public function messages()
    {
        return [

            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',

            'brand_id.exists' => 'Selected brand does not exist.',

            'unit_id.required' => 'Unit is required.',
            'unit_id.exists' => 'Selected unit does not exist.',

            'supplier_id.exists' => 'Selected supplier does not exist.',

            'name.required' => 'Product name is required.',
            'name.max' => 'Product name cannot exceed 255 characters.',

            'sku.required' => 'SKU is required.',
            'sku.unique' => 'SKU already exists.',

            'cost_price.required' => 'Cost price is required.',
            'cost_price.numeric' => 'Cost price must be a number.',
            'cost_price.min' => 'Cost price cannot be negative.',

            'selling_price.required' => 'Selling price is required.',
            'selling_price.numeric' => 'Selling price must be a number.',
            'selling_price.min' => 'Selling price cannot be negative.',

            'stock_alert.required' => 'Stock alert is required.',
            'stock_alert.integer' => 'Stock alert must be an integer.',

            'image.image' => 'Image must be an image file.',
            'image.mimes' => 'Image must be in jpg, jpeg, png, or webp format.',

            'status.required' => 'Status is required.',
            'status.boolean' => 'Status must be true or false.',

            'opening_stock.required' => 'Opening stock is required.',
            'opening_stock.integer' => 'Opening stock must be an integer.',
            'opening_stock.min' => 'Opening stock cannot be negative.',
        ];
    }
}
