<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|max:20|unique:customers,phone,' . $this->customer,
            'address' => 'nullable',
            'city' => 'nullable|max:100',
            'state' => 'nullable|max:100',
            'zip_code' => 'nullable|max:20',
            'customer_type' => 'required',
            'status' => 'required',
            'image' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'email.email' => 'Email must be valid.',
            'phone.required' => 'Phone is required.',
            'phone.unique' => 'Phone already exists.',
            'address.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'zip_code.required' => 'Zip code is required.',
            'customer_type.required' => 'Customer type is required.',
            'status.required' => 'Status is required.',
            'image.image' => 'Image must be an image.',
        ];
    }
}
