<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository
{
    public function getAll()
    {
        return Category::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Category::create($data);
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);

        $category->update($data);

        return $category;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        return $category->delete();
    }
}
