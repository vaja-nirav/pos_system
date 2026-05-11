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

class ProductController extends Controller implements HasMiddleware
{
    protected $productService;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_products', only: ['index']),
            new Middleware('permission:create_products', only: ['create', 'store']),
            new Middleware('permission:update_products', only: ['edit', 'update']),
            new Middleware('permission:delete_products', only: ['destroy']),
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
