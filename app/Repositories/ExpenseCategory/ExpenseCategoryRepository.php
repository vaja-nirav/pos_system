<?php

namespace App\Repositories\ExpenseCategory;

use App\Models\ExpenseCategory;

class ExpenseCategoryRepository
{
    public function getAll()
    {
        return ExpenseCategory::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return ExpenseCategory::create($data);
    }

    public function findById($id)
    {
        return ExpenseCategory::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);

        $expenseCategory->update($data);

        return $expenseCategory;
    }

    public function delete($id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);

        return $expenseCategory->delete();
    }
}
