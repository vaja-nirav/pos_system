<?php

namespace App\Repositories\Expense;

use App\Models\Expense;

class ExpenseRepository
{
    public function getAll()
    {
        return Expense::with('category')->latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Expense::create($data);
    }

    public function findById($id)
    {
        return Expense::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $expense = Expense::findOrFail($id);

        $expense->update($data);

        return $expense;
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);

        return $expense->delete();
    }
}
