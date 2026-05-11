<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Optional: Customize error messages
     */
    public function messages()
    {
        return [
            'name.required' => 'Category name is required.',
            'name.unique'   => 'This category already exists.',
            'image.image'   => 'Please upload a valid image file.',
            'image.mimes'   => 'Image must be JPG, JPEG, PNG, or WEBP.',
        ];
    }
}
