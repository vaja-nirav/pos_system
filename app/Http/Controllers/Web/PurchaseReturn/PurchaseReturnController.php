<?php

namespace App\Http\Controllers\Web\PurchaseReturn;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseReturn\StorePurchaseReturnRequest;
use App\Http\Requests\PurchaseReturn\UpdatePurchaseReturnRequest;
use App\Models\Purchase;
use App\Services\PurchaseReturn\PurchaseReturnService;

class PurchaseReturnController extends Controller
{
    protected $service;

    public function __construct(PurchaseReturnService $service)
    {
        $this->service = $service;
    }

    /**
     * List all purchase returns.
     */
    public function index()
    {
        $returns = $this->service->getAll();

        return view('purchase-returns.index', compact('returns'));
    }

    /**
     * Show the form for creating a new purchase return.
     */
    public function create($purchaseId)
    {
        $purchase = Purchase::with('items.product', 'supplier')->findOrFail($purchaseId);

        return view('purchase-returns.create', compact('purchase'));
    }

    /**
     * Store a new purchase return.
     */
    public function store(StorePurchaseReturnRequest $request)
    {
        try {
            $this->service->store($request);

            return redirect()
                ->route('purchase-returns.index')
                ->with('success', 'Purchase return created successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show a single purchase return.
     */
    public function show($id)
    {
        $return = $this->service->findById($id);

        return view('purchase-returns.show', compact('return'));
    }

    /**
     * Show the form for editing a purchase return.
     */
    public function edit($id)
    {
        $return = $this->service->findById($id);

        $purchase = Purchase::with('items.product', 'supplier')
            ->findOrFail($return->purchase_id);

        return view('purchase-returns.edit', compact('return', 'purchase'));
    }

    /**
     * Update an existing purchase return.
     */
    public function update(UpdatePurchaseReturnRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);

            return redirect()
                ->route('purchase-returns.index')
                ->with('success', 'Purchase return updated successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a purchase return and restore stock.
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()
            ->route('purchase-returns.index')
            ->with('success', 'Purchase return deleted and stock restored.');
    }
}