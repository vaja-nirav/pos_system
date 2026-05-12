<?php

namespace App\Http\Controllers\Web\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\Variation;
use App\Models\Warehouse;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Imports\ProductImport;

class ProductController extends Controller implements HasMiddleware
{
    protected $productService;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_products', only: ['index']),
            new Middleware('permission:create_products', only: ['create', 'store', 'import', 'downloadSample']),
            new Middleware('permission:update_products', only: ['edit', 'update']),
            new Middleware('permission:delete_products', only: ['destroy']),
            new Middleware('permission:export_products', only: ['export']),
        ];
    }

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAll();

        return view('products.index', compact('products'));
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'products_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv,txt'
        ]);

        try {
            Excel::import(new ProductImport, $request->file('file'));
            return redirect()->back()->with('success', "Products imported successfully.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Import failed: " . $e->getMessage());
        }
    }

    public function downloadSample()
    {
        $filename = "product_import_sample.xlsx";
        $export = new class implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function array(): array {
                return [[
                    'Example Product', 'PROD001', 'single', 'Electronics', 'Sony', 'piece', 
                    '100', '150', '50', '10', 'High quality electronics item'
                ]];
            }
            public function headings(): array {
                return [
                    'Name', 'SKU', 'Product Type', 'Category', 'Brand', 'Unit', 
                    'Cost Price', 'Selling Price', 'Stock', 'Stock Alert', 'Description'
                ];
            }
        };

        return Excel::download($export, $filename);
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->store($request);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product Created Successfully');
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();

        $brands = Brand::where('status', 1)->get();

        $units = Unit::where('status', 1)->get();

        $suppliers = Supplier::where('status', 1)->get();

        $variations = Variation::where('status', 1)->get();

        $warehouses = Warehouse::where('status', 1)->get();

        return view('products.create', compact(
            'categories',
            'brands',
            'units',
            'suppliers',
            'variations',
            'warehouses'
        ));
    }

    public function edit($id)
    {
        $product = $this->productService->findById($id);

        $categories = \App\Models\Category::where('status', 1)->get();

        $brands = \App\Models\Brand::where('status', 1)->get();

        $units = \App\Models\Unit::where('status', 1)->get();

        $suppliers = Supplier::where('status', 1)->get();

        $variations = Variation::where('status', 1)->get();

        $warehouses = Warehouse::where('status', 1)->get();

        return view('products.edit', compact(
            'product',
            'categories',
            'brands',
            'units',
            'suppliers',
            'variations',
            'warehouses'
        ));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $this->productService->update($request, $id);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product Updated Successfully');
    }

    public function destroy($id)
    {
        $this->productService->delete($id);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product Deleted Successfully');
    }
}
