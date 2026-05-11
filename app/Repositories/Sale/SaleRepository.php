<?php

namespace App\Repositories\Sale;

use App\Models\Sale;

class SaleRepository
{
    public function getAll()
    {
        return Sale::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Sale::create($data);
    }

    public function findById($id)
    {
        return Sale::with('items.product', 'customer')
            ->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $sale = Sale::findOrFail($id);

        $sale->update($data);

        return $sale;
    }

    public function delete($id)
    {
        $sale = Sale::findOrFail($id);

        return $sale->delete();
    }
}
