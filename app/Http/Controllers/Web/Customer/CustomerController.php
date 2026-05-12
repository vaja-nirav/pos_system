<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Services\Customer\CustomerService;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAll();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $this->customerService->store($request);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer Created Successfully');
    }

    public function edit($id)
    {
        $customer = $this->customerService->findById($id);

        return view('customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $this->customerService->update($request, $id);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer Updated Successfully');
    }

    public function destroy($id)
    {
        $this->customerService->delete($id);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer Deleted Successfully');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CustomerExport, 'customers_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv,txt'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\CustomerImport, $request->file('file'));
            return redirect()->back()->with('success', "Customers imported successfully.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Import failed: " . $e->getMessage());
        }
    }

    public function downloadSample()
    {
        $filename = "customer_import_sample.xlsx";
        $export = new class implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function array(): array {
                return [[
                    'John Doe', 'john@example.com', '1234567890', 'ACME Corp', 'TAX123', '123 Main St', 'New York', 'Active'
                ]];
            }
            public function headings(): array {
                return ['Name', 'Email', 'Phone', 'Company', 'Tax Number', 'Address', 'City', 'Status'];
            }
        };

        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
    }
}
