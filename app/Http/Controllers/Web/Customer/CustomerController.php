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
}
