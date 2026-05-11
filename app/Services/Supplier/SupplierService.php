<?php

namespace App\Services\Supplier;

use App\Repositories\Supplier\SupplierRepository;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAll()
    {
        return $this->supplierRepository->getAll();
    }

    public function findById($id)
    {
        return $this->supplierRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        $supplier = $this->supplierRepository->store($data);

        // Upload Image
        if ($request->hasFile('image')) {

            $supplier
                ->addMedia($request->file('image'))
                ->toMediaCollection('suppliers');
        }

        return $supplier;
    }

    public function update($request, $id)
    {
        $supplier = $this->supplierRepository->findById($id);

        $data = $request->validated();

        $this->supplierRepository->update($id, $data);

        // Replace Image
        if ($request->hasFile('image')) {

            $supplier->clearMediaCollection('suppliers');

            $supplier
                ->addMedia($request->file('image'))
                ->toMediaCollection('suppliers');
        }

        return $supplier;
    }

    public function delete($id)
    {
        $supplier = $this->supplierRepository->findById($id);

        $supplier->clearMediaCollection('suppliers');

        return $this->supplierRepository->delete($id);
    }
}