<?php

namespace App\Services\Sale;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
                'invoice_no' => 'SALE-'.strtoupper(Str::random(8)),
                'customer_id' => ! empty($data['customer_id']) ? $data['customer_id'] : null,
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
                    'variation' => $item['variation'] ?? null,
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                // Deduct Stock
                $product = Product::find($item['id']);
                if ($product) {
                    $requestedQty = (int) $item['qty'];
                    $isVariation = ($product->product_type === 'variation');
                    $variationName = ! empty($item['variation']) ? trim($item['variation']) : null;

                    if ($isVariation && $variationName) {
                        $variations = $product->variations;

                        // Robust Key Matching
                        $matchKey = null;
                        if (is_array($variations)) {
                            foreach ($variations as $key => $v) {
                                if (strtolower(trim($key)) === strtolower($variationName)) {
                                    $matchKey = $key;
                                    break;
                                }
                            }
                        }

                        if ($matchKey) {
                            $availableStock = (int) ($variations[$matchKey]['opening_stock'] ?? 0);

                            // Backend Guard
                            if ($requestedQty > $availableStock) {
                                throw ValidationException::withMessages([
                                    'stock' => ["Insufficient stock for {$product->name} ({$variationName}). Available: {$availableStock}"],
                                ]);
                            }

                            // Update variant-specific stock
                            $variations[$matchKey]['opening_stock'] = $availableStock - $requestedQty;
                            $product->variations = $variations;

                            // Recalculate total current_stock from all variants
                            $totalStock = 0;
                            foreach ($variations as $v) {
                                $totalStock += (int) ($v['opening_stock'] ?? 0);
                            }
                            $product->current_stock = $totalStock;
                        } else {
                            // Fallback
                            if ($requestedQty > $product->current_stock) {
                                throw ValidationException::withMessages([
                                    'stock' => ["Insufficient stock for {$product->name}. Available: {$product->current_stock}"],
                                ]);
                            }
                            $product->current_stock = (int) $product->current_stock - $requestedQty;
                        }
                    } else {
                        // Standard Product Stock update
                        if ($requestedQty > $product->current_stock) {
                            throw ValidationException::withMessages([
                                'stock' => ["Insufficient stock for {$product->name}. Available: {$product->current_stock}"],
                            ]);
                        }
                        $product->current_stock = (int) $product->current_stock - $requestedQty;
                    }

                    $product->save();
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
                'sale_date' => $data['sale_date'] ?? $sale->sale_date,
                'payment_status' => $data['payment_status'] ?? $sale->payment_status,
                'payment_type' => $data['payment_type'] ?? $sale->payment_type,
                'paid_amount' => $data['paid_amount'] ?? $sale->paid_amount,
                'note' => $data['note'] ?? $sale->note,
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
