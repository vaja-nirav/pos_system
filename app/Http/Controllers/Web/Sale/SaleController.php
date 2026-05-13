<?php

namespace App\Http\Controllers\Web\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Services\Sale\SaleService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SaleController extends Controller implements HasMiddleware
{
    protected $saleService;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_sale', only: ['index', 'show']),
            new Middleware('permission:create_sale', only: ['create', 'store']),
            new Middleware('permission:update_sale', only: ['edit', 'update']),
            new Middleware('permission:delete_sale', only: ['destroy']),
        ];
    }

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $sales = $this->saleService->getAll();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::where('status', 1)->get();

        $products = Product::where('status', 1)->get();

        return view('sales.create', compact(
            'customers',
            'products'
        ));
    }

    public function store(StoreSaleRequest $request)
    {
        $data = $request->validated();
        
        // Restructure products into items array for Service
        $items = [];
        foreach ($request->product_id as $index => $productId) {
            $items[] = [
                'id' => $productId,
                'qty' => $request->quantity[$index],
                'price' => $request->price[$index],
                'variation' => $request->variation_name[$index] ?? null,
            ];
        }
        
        $data['items'] = $items;

        $sale = $this->saleService->store($data);

        return redirect()->route(
            'sales.index'
        )->with('success', 'Sale Created Successfully');
    }

    public function edit($id)
    {
        $sale = $this->saleService->findById($id);

        $customers = Customer::where('status', 1)->get();

        $products = Product::where('status', 1)->get();

        return view('sales.edit', compact(
            'sale',
            'customers',
            'products'
        ));
    }

    public function update(UpdateSaleRequest $request, $id)
    {
        $this->saleService->update($request, $id);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale Updated Successfully');
    }

    public function show($id)
    {
        $sale = $this->saleService->findById($id);

        return view('sales.show', compact('sale'));
    }

    public function destroy($id)
    {
        $this->saleService->delete($id);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale Deleted Successfully');
    }
}
