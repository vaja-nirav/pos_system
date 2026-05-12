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

        // Process Variations if applicable
        if ($request->product_type === 'variation' && $request->has('variations')) {
            $formattedVariations = [];
            foreach ($request->variations as $type) {
                $formattedVariations[$type] = [
                    'cost' => $request->variation_cost[$type] ?? 0,
                    'price' => $request->variation_price[$type] ?? 0,
                    'sku' => $request->variation_sku[$type] ?? '',
                    'opening_stock' => $request->variation_opening_stock[$type] ?? 0,
                    'stock_alert' => $request->variation_stock_alert[$type] ?? 10,
                ];
            }
            $data['variations'] = $formattedVariations;

            // Set default values for main fields to avoid DB null errors
            $data['cost_price'] = $data['cost_price'] ?? 0;
            $data['selling_price'] = $data['selling_price'] ?? 0;
            $data['opening_stock'] = $data['opening_stock'] ?? 0;
            $data['current_stock'] = $data['current_stock'] ?? 0;
            $data['stock_alert'] = $data['stock_alert'] ?? 10;
        }

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

        // Process Variations if applicable
        if ($request->product_type === 'variation' && $request->has('variations')) {
            $formattedVariations = [];
            foreach ($request->variations as $type) {
                $formattedVariations[$type] = [
                    'cost' => $request->variation_cost[$type] ?? 0,
                    'price' => $request->variation_price[$type] ?? 0,
                    'sku' => $request->variation_sku[$type] ?? '',
                    'opening_stock' => $request->variation_opening_stock[$type] ?? 0,
                    'stock_alert' => $request->variation_stock_alert[$type] ?? 10,
                ];
            }
            $data['variations'] = $formattedVariations;
        } else {
            $data['variations'] = null;
        }

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
