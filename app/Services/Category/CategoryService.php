<?php

namespace App\Services\Category;

use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Str;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function findById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        // Generate Slug
        $data['slug'] = Str::slug($request->name);

        // Create Category
        $category = $this->categoryRepository->store($data);

        // Upload Image Using Media Library
        if ($request->hasFile('image')) {
            $category
                ->addMedia($request->file('image'))
                ->toMediaCollection('categories');
        }

        return $category;
    }

    public function update($request, $id)
    {
        $category = $this->categoryRepository->findById($id);

        $data = $request->validated();

        // Update Slug
        $data['slug'] = Str::slug($request->name);

        // Update Category
        $this->categoryRepository->update($id, $data);

        // Replace Image
        if ($request->hasFile('image')) {
            // Remove Old Image
            $category->clearMediaCollection('categories');

            // Upload New Image
            $category
                ->addMedia($request->file('image'))
                ->toMediaCollection('categories');
        }

        return $category;
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->findById($id);

        // Delete Media
        $category->clearMediaCollection('categories');

        return $this->categoryRepository->delete($id);
    }
}
