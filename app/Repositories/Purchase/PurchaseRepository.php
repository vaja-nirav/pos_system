<?php

namespace App\Repositories\Purchase;

use App\Models\Purchase;

class PurchaseRepository
{
    public function getAll()
    {
        return Purchase::with([
            'supplier',
        ])
            ->latest()
            ->paginate(10);
    }

    public function store(array $data)
    {
        return Purchase::create($data);
    }

    public function findById($id)
    {
        return Purchase::with([
            'supplier',
            'items.product',
        ])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $purchase = Purchase::findOrFail($id);

        $purchase->update($data);

        return $purchase;
    }

    public function delete($id)
    {
        $purchase = Purchase::findOrFail($id);

        return $purchase->delete();
    }
}
