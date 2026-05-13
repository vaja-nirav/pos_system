<?php

namespace App\Http\Controllers\Web\POS;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Warehouse;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class POSController extends Controller implements HasMiddleware
{
    protected $saleService;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_pos_screen', only: ['index']),
            new Middleware('permission:create_pos_screen|create_sale', only: ['store']),
        ];
    }

    public function __construct(\App\Services\Sale\SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $products = Product::with(['media', 'unit'])->where('status', 1)->latest()->get();
        $customers = Customer::where('status', 1)->get();
        $warehouses = Warehouse::where('status', 1)->get();

        return view('pos.index', compact('categories', 'brands', 'products', 'customers', 'warehouses'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        try {
            $sale = $this->saleService->store($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Sale created successfully',
                'sale' => $sale
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
