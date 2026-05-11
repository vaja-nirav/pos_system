<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Str;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    public function findById($id)
    {
        return $this->productRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        // Current Stock
        $data['current_stock'] = $request->opening_stock;

        // Generate Slug
        $data['slug'] = Str::slug($request->name);

        // Create Product
        $product = $this->productRepository->store($data);

        // Upload Image Using Media Library
        if ($request->hasFile('image')) {
            $product->addMedia($request->file('image'))->toMediaCollection('products');
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $product->addMedia($file)->toMediaCollection('products');
            }
        }

        return $product;
    }

    public function update($request, $id)
    {
        $product = $this->productRepository->findById($id);

        $data = $request->validated();

        // Update Slug
        $data['slug'] = Str::slug($request->name);

        // Update Product
        $this->productRepository->update($id, $data);

        // Replace Product Image
        if ($request->hasFile('image') || $request->hasFile('images')) {
            // Remove Old Image
            $product->clearMediaCollection('products');

            // Upload New Image(s)
            if ($request->hasFile('image')) {
                $product->addMedia($request->file('image'))->toMediaCollection('products');
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $product->addMedia($file)->toMediaCollection('products');
                }
            }
        }

        return $product;
    }

    public function delete($id)
    {
        $product = $this->productRepository->findById($id);

        // Delete All Product Images
        $product->clearMediaCollection('products');

        return $this->productRepository->delete($id);
    }
}
