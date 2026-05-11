<?php

namespace App\Http\Requests\Expense;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            'expense_category_id' => 'required|exists:expense_categories,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'note' => 'nullable',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'expense_category_id.required' => 'Expense category is required.',
            'expense_category_id.exists' => 'Expense category is invalid.',
            'title.required' => 'Title is required.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount must be at least 1.',
            'expense_date.required' => 'Expense date is required.',
            'expense_date.date' => 'Expense date must be a valid date.',
            'note.nullable' => 'Note can be empty.',
            'status.required' => 'Status is required.',
        ];
    }
}
