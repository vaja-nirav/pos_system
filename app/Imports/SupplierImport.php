<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['name']) || empty($row['phone'])) {
            return null;
        }

        return Supplier::updateOrCreate(
            ['phone' => $row['phone']],
            [
                'name' => $row['name'],
                'email' => $row['email'] ?? null,
                'company' => $row['company'] ?? null,
                'tax_number' => $row['tax_number'] ?? null,
                'address' => $row['address'] ?? null,
                'city' => $row['city'] ?? null,
                'status' => strtolower($row['status'] ?? '') === 'inactive' ? 0 : 1,
                'store_id' => auth()->user()->store_id ?? 1
            ]
        );
    }
}
