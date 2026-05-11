<?php

namespace App\Http\Requests\Brand;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:brands,name',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'status' => 'required|boolean',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Brand name is required',
            'name.unique' => 'Brand name is already taken',
            'image.image' => 'Image must be an image',
            'image.mimes' => 'Image must be a jpg, jpeg, png, or webp file',
            'status.required' => 'Status is required',
            'status.boolean' => 'Status must be a boolean',
        ];
    }
}
