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

class SaleController extends Controller 
{
    protected $saleService;

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
        $sale = $this->saleService->store($request);

        return redirect()->route(
            'invoice.show',
            $sale->id
        );
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
