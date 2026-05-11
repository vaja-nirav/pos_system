<?php

namespace App\Repositories\Brand;

use App\Models\Brand;

class BrandRepository
{
    public function getAll()
    {
        return Brand::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Brand::create($data);
    }

    public function findById($id)
    {
        return Brand::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $brand = Brand::findOrFail($id);

        $brand->update($data);

        return $brand;
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);

        return $brand->delete();
    }
}
