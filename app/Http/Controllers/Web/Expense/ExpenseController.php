<?php

namespace App\Http\Controllers\Web\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;
use App\Models\ExpenseCategory;
use App\Services\Expense\ExpenseService;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index()
    {
        $expenses = $this->expenseService->getAll();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $expenseCategories = ExpenseCategory::where('status', 1)->get();

        return view('expenses.create', compact('expenseCategories'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $this->expenseService->store($request);

        return redirect()->route('expenses.index')->with('success', 'Expense Created Successfully');
    }

    public function edit($id)
    {
        $expense = $this->expenseService->findById($id);

        $expenseCategories = ExpenseCategory::where('status', 1)->get();

        return view('expenses.edit', compact('expense', 'expenseCategories'));
    }

    public function update(UpdateExpenseRequest $request, $id)
    {
        $this->expenseService->update($request, $id);

        return redirect()->route('expenses.index')->with('success', 'Expense Updated Successfully');
    }

    public function destroy($id)
    {
        $this->expenseService->delete($id);

        return redirect()->route('expenses.index')->with('success', 'Expense Deleted Successfully');
    }
}
