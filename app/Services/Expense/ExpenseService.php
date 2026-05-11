<?php

namespace App\Services\Expense;

use App\Repositories\Expense\ExpenseRepository;

class ExpenseService
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function getAll()
    {
        return $this->expenseRepository->getAll();
    }

    public function findById($id)
    {
        return $this->expenseRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        return $this->expenseRepository->store($data);
    }

    public function update($request, $id)
    {
        $data = $request->validated();

        return $this->expenseRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->expenseRepository->delete($id);
    }
}
