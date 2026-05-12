<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['name']) || empty($row['sku'])) {
            return null;
        }

        $categoryName = $row['category'] ?? 'General';
        $brandName = $row['brand'] ?? null;
        $unitShortName = $row['unit'] ?? 'pc';

        $category = Category::firstOrCreate(
            ['name' => $categoryName], 
            ['status' => 1, 'slug' => Str::slug($categoryName)]
        );
        
        $brand = !empty($brandName) ? Brand::firstOrCreate(
            ['name' => $brandName], 
            ['status' => 1, 'slug' => Str::slug($brandName)]
        ) : null;
        
        $unit = Unit::firstOrCreate(
            ['short_name' => $unitShortName], 
            ['name' => $unitShortName, 'status' => 1]
        );

        return Product::updateOrCreate(
            ['sku' => $row['sku']],
            [
                'name' => $row['name'],
                'product_type' => strtolower($row['product_type'] ?? 'single') ?: 'single',
                'category_id' => $category->id,
                'brand_id' => $brand?->id,
                'unit_id' => $unit->id,
                'cost_price' => (float)($row['cost_price'] ?? 0),
                'selling_price' => (float)($row['selling_price'] ?? 0),
                'opening_stock' => (float)($row['stock'] ?? 0),
                'current_stock' => (float)($row['stock'] ?? 0),
                'stock_alert' => (float)($row['stock_alert'] ?? 0),
                'description' => $row['description'] ?? '',
                'status' => 1,
                'store_id' => auth()->user()->store_id ?? 1,
                'slug' => Str::slug($row['name']) . '-' . $row['sku']
            ]
        );
    }
}
