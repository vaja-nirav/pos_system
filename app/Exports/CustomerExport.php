<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomerExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Customer::all();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Company',
            'Tax Number',
            'Address',
            'City',
            'Status'
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->name,
            $customer->email,
            $customer->phone,
            $customer->company,
            $customer->tax_number,
            $customer->address,
            $customer->city,
            $customer->status ? 'Active' : 'Inactive'
        ];
    }
}
