<?php

namespace App\Repositories\Supplier;

use App\Models\Supplier;

class SupplierRepository
{
    public function getAll()
    {
        return Supplier::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Supplier::create($data);
    }

    public function findById($id)
    {
        return Supplier::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $supplier = Supplier::findOrFail($id);

        return $supplier->update($data);
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);

        return $supplier->delete();
    }
}