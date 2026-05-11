<?php

namespace App\Http\Controllers\Web\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Services\Supplier\SupplierService;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        $suppliers = $this->supplierService->getAll();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(StoreSupplierRequest $request)
    {
        $this->supplierService->store($request);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier Created Successfully');
    }

    public function edit($id)
    {
        $supplier = $this->supplierService->findById($id);

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        $this->supplierService->update($request, $id);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier Updated Successfully');
    }

    public function destroy($id)
    {
        $this->supplierService->delete($id);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier Deleted Successfully');
    }
}
