<?php

namespace App\Services\Customer;

use App\Repositories\Customer\CustomerRepository;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll()
    {
        return $this->customerRepository->getAll();
    }

    public function findById($id)
    {
        return $this->customerRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        $customer = $this->customerRepository->store($data);

        // Upload Image
        if ($request->hasFile('image')) {
            $customer
                ->addMedia($request->file('image'))
                ->toMediaCollection('customers');
        }

        return $customer;
    }

    public function update($request, $id)
    {
        $customer = $this->customerRepository->findById($id);

        $data = $request->validated();

        $this->customerRepository->update($id, $data);

        // Replace Image
        if ($request->hasFile('image')) {
            $customer->clearMediaCollection('customers');

            $customer
                ->addMedia($request->file('image'))
                ->toMediaCollection('customers');
        }

        return $customer;
    }

    public function delete($id)
    {
        $customer = $this->customerRepository->findById($id);

        $customer->clearMediaCollection('customers');

        return $this->customerRepository->delete($id);
    }
}
