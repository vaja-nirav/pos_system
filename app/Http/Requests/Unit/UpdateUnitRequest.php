<?php

namespace App\Http\Requests\Unit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
        $unitId = $this->route('unit');

        return [
            'name' => 'required|string|max:255|unique:units,name,' . $unitId,
            'short_name' => 'required|string|max:50',
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Unit name is required.',
            'name.unique' => 'Unit name already exists.',
            'short_name.required' => 'Short name is required.',
            'status.required' => 'Status is required.',
        ];
    }
}
