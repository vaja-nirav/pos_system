<?php

namespace App\Http\Controllers\Web\SaleReturn;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleReturn\StoreSaleReturnRequest;
use App\Http\Requests\SaleReturn\UpdateSaleReturnRequest;
use App\Models\Sale;
use App\Services\SaleReturn\SaleReturnService;

class SaleReturnController extends Controller
{
    protected $service;

    public function __construct(SaleReturnService $service)
    {
        $this->service = $service;
    }

    /**
     * List all sale returns.
     */
    public function index()
    {
        $returns = $this->service->getAll();

        return view('sale-returns.index', compact('returns'));
    }

    /**
     * Show the form for creating a new sale return.
     */
    public function create($saleId)
    {
        $sale = Sale::with('items.product', 'customer')->findOrFail($saleId);

        return view('sale-returns.create', compact('sale'));
    }

    /**
     * Store a new sale return.
     */
    public function store(StoreSaleReturnRequest $request)
    {
        try {
            $this->service->store($request);

            return redirect()
                ->route('sale-returns.index')
                ->with('success', 'Sale return created successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show a single sale return.
     */
    public function show($id)
    {
        $return = $this->service->findById($id);

        return view('sale-returns.show', compact('return'));
    }

    /**
     * Show the form for editing a sale return.
     */
    public function edit($id)
    {
        $return = $this->service->findById($id);

        $sale = Sale::with('items.product', 'customer')
            ->findOrFail($return->sale_id);

        return view('sale-returns.edit', compact('return', 'sale'));
    }

    /**
     * Update an existing sale return.
     */
    public function update(UpdateSaleReturnRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);

            return redirect()
                ->route('sale-returns.index')
                ->with('success', 'Sale return updated successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a sale return and reverse stock restoration.
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()
            ->route('sale-returns.index')
            ->with('success', 'Sale return deleted and stock adjusted.');
    }
}
