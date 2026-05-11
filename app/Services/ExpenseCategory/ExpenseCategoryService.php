<?php

namespace App\Services\ExpenseCategory;

use Illuminate\Support\Str;
use App\Repositories\ExpenseCategory\ExpenseCategoryRepository;

class ExpenseCategoryService
{
    protected $expenseCategoryRepository;

    public function __construct(ExpenseCategoryRepository $expenseCategoryRepository) {
        
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    public function getAll()
    {
        return $this->expenseCategoryRepository->getAll();
    }

    public function findById($id)
    {
        return $this->expenseCategoryRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->name);

        return $this->expenseCategoryRepository->store($data);
    }

    public function update($request, $id)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->name);

        return $this->expenseCategoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->expenseCategoryRepository->delete($id);
    }
}