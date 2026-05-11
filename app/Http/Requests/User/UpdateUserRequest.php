<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users,email,' . $userId],
            'phone'                 => ['nullable', 'string', 'max:20'],
            'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable'],
            'role'                  => ['required', 'string', 'exists:roles,name'],
            'status'                => ['nullable', 'boolean'],
        ];
    }
}
