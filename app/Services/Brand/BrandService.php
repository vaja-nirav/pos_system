<?php

namespace App\Services\Brand;

use App\Repositories\Brand\BrandRepository;
use Illuminate\Support\Str;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAll()
    {
        return $this->brandRepository->getAll();
    }

    public function findById($id)
    {
        return $this->brandRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        // Generate Slug
        $data['slug'] = Str::slug($request->name);

        // Create Brand
        $brand = $this->brandRepository->store($data);

        // Upload Image Using Media Library
        if ($request->hasFile('image')) {
            $brand
                ->addMedia($request->file('image'))
                ->toMediaCollection('brands');
        }

        return $brand;
    }

    public function update($request, $id)
    {
        $brand = $this->brandRepository->findById($id);

        $data = $request->validated();

        // Update Slug
        $data['slug'] = Str::slug($request->name);

        // Update Brand
        $this->brandRepository->update($id, $data);

        // Replace Image
        if ($request->hasFile('image')) {
            // Remove Old Image
            $brand->clearMediaCollection('brands');

            // Upload New Image
            $brand
                ->addMedia($request->file('image'))
                ->toMediaCollection('brands');
        }

        return $brand;
    }

    public function delete($id)
    {
        $brand = $this->brandRepository->findById($id);

        // Delete Media
        $brand->clearMediaCollection('brands');

        return $this->brandRepository->delete($id);
    }
}
