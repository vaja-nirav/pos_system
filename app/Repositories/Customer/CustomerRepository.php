<?php

namespace App\Repositories\Customer;

use App\Models\Customer;

class CustomerRepository
{
    public function getAll()
    {
        return Customer::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Customer::create($data);
    }

    public function findById($id)
    {
        return Customer::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $customer = Customer::findOrFail($id);

        return $customer->update($data);
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);

        return $customer->delete();
    }
}