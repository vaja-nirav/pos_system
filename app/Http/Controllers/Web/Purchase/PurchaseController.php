<?php

namespace App\Http\Controllers\Web\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\Purchase\PurchaseService;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function index()
    {
        $purchases = $this->purchaseService->getAll();

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 1)->get();

        $products = Product::where('status', 1)->get();

        $invoiceNo = 'PUR-' . str_pad(
            rand(1, 9999),
            4,
            '0',
            STR_PAD_LEFT
        );

        return view('purchases.create', compact(
            'suppliers',
            'products',
            'invoiceNo'
        ));
    }

    public function store(StorePurchaseRequest $request)
    {
        $this->purchaseService->store($request);

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase Created Successfully');
    }

    public function edit($id)
    {
        $purchase = $this->purchaseService->findById($id);

        $suppliers = Supplier::where('status', 1)->get();

        $products = Product::where('status', 1)->get();

        return view('purchases.edit', compact(
            'purchase',
            'suppliers',
            'products'
        ));
    }

    public function update(UpdatePurchaseRequest $request, $id)
    {
        $this->purchaseService->update($request, $id);

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase Updated Successfully');
    }

    public function show($id)
    {
        $purchase = $this->purchaseService->findById($id);

        return view('purchases.show', compact('purchase'));
    }

    public function destroy($id)
    {
        $this->purchaseService->delete($id);

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase Deleted Successfully');
    }
}
