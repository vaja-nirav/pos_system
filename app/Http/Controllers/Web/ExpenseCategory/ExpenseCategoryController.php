<?php

namespace App\Http\Controllers\Web\ExpenseCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseCategory\StoreExpenseCategoryRequest;
use App\Http\Requests\ExpenseCategory\UpdateExpenseCategoryRequest;
use App\Services\ExpenseCategory\ExpenseCategoryService;

class ExpenseCategoryController extends Controller
{
    protected $expenseCategoryService;

    public function __construct(ExpenseCategoryService $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }

    public function index()
    {
        $expenseCategories = $this->expenseCategoryService->getAll();

        return view('expense-categories.index', compact('expenseCategories'));
    }

    public function create()
    {
        return view('expense-categories.create');
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $this->expenseCategoryService->store($request);

        return redirect()->route('expense-categories.index')->with('success', 'Expense Category Created Successfully');
    }

    public function edit($id)
    {
        $expenseCategory = $this->expenseCategoryService->findById($id);

        return view('expense-categories.edit', compact('expenseCategory'));
    }

    public function update(UpdateExpenseCategoryRequest $request, $id)
    {
        $this->expenseCategoryService->update($request, $id);

        return redirect()
            ->route('expense-categories.index')
            ->with('success', 'Expense Category Updated Successfully');
    }

    public function destroy($id)
    {
        $this->expenseCategoryService->delete($id);

        return redirect()
            ->route('expense-categories.index')
            ->with('success', 'Expense Category Deleted Successfully');
    }
}
