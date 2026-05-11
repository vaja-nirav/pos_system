<?php

namespace App\Services\Sale;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleService
{
    public function getAll()
    {
        return Sale::with(['customer', 'items'])->latest()->get();
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $sale = Sale::create([
                'invoice_no' => 'SALE-' . strtoupper(Str::random(8)),
                'customer_id' => $data['customer_id'] ?? null,
                'sale_date' => now(),
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'] ?? 0,
                'tax' => $data['tax'] ?? 0,
                'tax_percent' => $data['tax_percent'] ?? 0,
                'shipping' => $data['shipping'] ?? 0,
                'total' => $data['total'],
                'paid_amount' => $data['paid_amount'],
                'due_amount' => $data['total'] - $data['paid_amount'],
                'payment_status' => $data['payment_status'] ?? 'paid',
                'payment_type' => $data['payment_type'] ?? 'Cash',
                'note' => $data['note'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $sale->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                // Deduct Stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('current_stock', $item['qty']);
                }
            }

            return $sale->load(['items.product', 'customer']);
        });
    }

    public function findById($id)
    {
        return Sale::with(['items.product', 'customer'])->findOrFail($id);
    }

    public function update($data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $sale = Sale::findOrFail($id);
            
            // Note: Update logic can be complex if it involves restoring old stock and deducting new stock.
            // For now, updating basic fields.
            $sale->update([
                'customer_id' => $data['customer_id'] ?? $sale->customer_id,
                'paid_amount' => $data['paid_amount'] ?? $sale->paid_amount,
                'note' => $data['note'] ?? $sale->note,
                // other fields...
            ]);

            return $sale;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $sale = Sale::findOrFail($id);
            
            // Restore Stock before deleting
            foreach ($sale->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('current_stock', $item->quantity);
                }
            }

            return $sale->delete();
        });
    }
}
