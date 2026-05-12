<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SupplierExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Supplier::all();
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

    public function map($supplier): array
    {
        return [
            $supplier->name,
            $supplier->email,
            $supplier->phone,
            $supplier->company,
            $supplier->tax_number,
            $supplier->address,
            $supplier->city,
            $supplier->status ? 'Active' : 'Inactive'
        ];
    }
}
