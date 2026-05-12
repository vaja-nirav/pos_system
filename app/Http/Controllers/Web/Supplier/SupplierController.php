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

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SupplierExport, 'suppliers_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv,txt'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\SupplierImport, $request->file('file'));
            return redirect()->back()->with('success', "Suppliers imported successfully.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Import failed: " . $e->getMessage());
        }
    }

    public function downloadSample()
    {
        $filename = "supplier_import_sample.xlsx";
        $export = new class implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function array(): array {
                return [[
                    'Jane Smith', 'jane@example.com', '0987654321', 'Supply Co', 'TAX456', '456 Supply Lane', 'Chicago', 'Active'
                ]];
            }
            public function headings(): array {
                return ['Name', 'Email', 'Phone', 'Company', 'Tax Number', 'Address', 'City', 'Status'];
            }
        };

        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
    }
}
