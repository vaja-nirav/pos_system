<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['category', 'brand', 'unit'])->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'SKU',
            'Product Type',
            'Category',
            'Brand',
            'Unit',
            'Cost Price',
            'Selling Price',
            'Current Stock',
            'Stock Alert',
            'Description'
        ];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->sku,
            $product->product_type,
            $product->category?->name,
            $product->brand?->name,
            $product->unit?->name,
            $product->cost_price,
            $product->selling_price,
            $product->current_stock,
            $product->stock_alert,
            $product->description
        ];
    }
}
