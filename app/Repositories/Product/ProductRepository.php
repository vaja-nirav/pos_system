<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        return Product::with([
            'category',
            'brand',
            'unit',
            'supplier'
        ])
            ->latest()
            ->paginate(10);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);

        $product->update($data);

        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        return $product->delete();
    }
}
