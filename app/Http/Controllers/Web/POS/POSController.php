<?php

namespace App\Http\Controllers\Web\POS;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
class POSController extends Controller
{
    protected $saleService;

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

        return view('pos.index', compact('categories', 'brands', 'products', 'customers'));
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
