<?php

namespace App\Http\Requests\Variation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVariationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:variations,name,' . $this->route('variation')],
            'values' => ['required', 'array', 'min:1'],
            'values.*' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
        ];
    }
}
