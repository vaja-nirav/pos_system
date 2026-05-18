<?php

namespace App\Services\Quotation;

use App\Models\Product;
use App\Models\Quotation;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class QuotationService
{
    public function getAll()
    {
        return Quotation::with(['customer', 'items'])->latest()->get();
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $quotation = Quotation::create([
                'quotation_no' => 'QUO-'.strtoupper(Str::random(8)),
                'customer_id' => $data['customer_id'] ?? null,
                'store_id' => auth()->user()->store_id ?? null,
                'quotation_date' => $data['quotation_date'] ?? now(),
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'] ?? 0,
                'tax' => $data['tax'] ?? 0,
                'tax_percent' => $data['tax_percent'] ?? 0,
                'shipping' => $data['shipping'] ?? 0,
                'total' => $data['total'],
                'status' => 'pending',
                'note' => $data['note'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $quotation->items()->create([
                    'product_id' => $item['product_id'],
                    'variation' => $item['variation'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            return $quotation;
        });
    }

    public function findById($id)
    {
        return Quotation::with(['items.product', 'customer'])->findOrFail($id);
    }

    public function update($data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $quotation = Quotation::findOrFail($id);

            $quotation->update([
                'customer_id' => $data['customer_id'] ?? $quotation->customer_id,
                'quotation_date' => $data['quotation_date'] ?? $quotation->quotation_date,
                'subtotal' => $data['subtotal'] ?? $quotation->subtotal,
                'discount' => $data['discount'] ?? $quotation->discount,
                'tax' => $data['tax'] ?? $quotation->tax,
                'tax_percent' => $data['tax_percent'] ?? $quotation->tax_percent,
                'shipping' => $data['shipping'] ?? $quotation->shipping,
                'total' => $data['total'] ?? $quotation->total,
                'note' => $data['note'] ?? $quotation->note,
            ]);

            if (isset($data['items'])) {
                $quotation->items()->delete();
                foreach ($data['items'] as $item) {
                    $quotation->items()->create([
                        'product_id' => $item['product_id'],
                        'variation' => $item['variation'] ?? null,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);
                }
            }

            return $quotation;
        });
    }

    public function approve($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'approved']);

        return $quotation;
    }

    public function convertToSale($id)
    {
        return DB::transaction(function () use ($id) {
            $quotation = Quotation::with('items')->findOrFail($id);

            if ($quotation->status === 'converted') {
                throw new \Exception('Quotation already converted to sale.');
            }

            // Create Sale
            $sale = Sale::create([
                'invoice_no' => 'SALE-'.strtoupper(Str::random(8)),
                'customer_id' => $quotation->customer_id,
                'sale_date' => now(),
                'subtotal' => $quotation->subtotal,
                'discount' => $quotation->discount,
                'tax' => $quotation->tax,
                'tax_percent' => $quotation->tax_percent,
                'shipping' => $quotation->shipping,
                'total' => $quotation->total,
                'paid_amount' => 0, // Default to 0, user can update later
                'due_amount' => $quotation->total,
                'payment_status' => 'due',
                'payment_type' => 'Cash',
                'note' => 'Converted from Quotation: '.$quotation->quotation_no.'. '.$quotation->note,
            ]);

            foreach ($quotation->items as $item) {
                // Deduct Stock
                $product = Product::find($item->product_id);
                if ($product) {
                    $requestedQty = (int) $item->quantity;
                    $isVariation = ($product->product_type === 'variation');
                    $variationName = ! empty($item->variation) ? trim($item->variation) : null;

                    if ($isVariation && $variationName) {
                        $variations = $product->variations;
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

                            if ($requestedQty > $availableStock) {
                                throw ValidationException::withMessages([
                                    'stock' => ["Insufficient stock for {$product->name} ({$variationName}) to convert quotation. Available: {$availableStock}"],
                                ]);
                            }

                            $variations[$matchKey]['opening_stock'] = $availableStock - $requestedQty;
                            $product->variations = $variations;

                            $totalStock = 0;
                            foreach ($variations as $v) {
                                $totalStock += (int) ($v['opening_stock'] ?? 0);
                            }
                            $product->current_stock = $totalStock;
                        } else {
                            if ($requestedQty > $product->current_stock) {
                                throw ValidationException::withMessages([
                                    'stock' => ["Insufficient stock for {$product->name} to convert quotation."],
                                ]);
                            }
                            $product->current_stock = (int) $product->current_stock - $requestedQty;
                        }
                    } else {
                        if ($requestedQty > $product->current_stock) {
                            throw ValidationException::withMessages([
                                'stock' => ["Insufficient stock for {$product->name} to convert quotation. Available: {$product->current_stock}"],
                            ]);
                        }
                        $product->current_stock = (int) $product->current_stock - $requestedQty;
                    }
                    $product->save();
                }

                $sale->items()->create([
                    'product_id' => $item->product_id,
                    'variation' => $item->variation,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            $quotation->update(['status' => 'converted']);

            return $sale;
        });
    }

    public function delete($id)
    {
        $quotation = Quotation::findOrFail($id);

        return $quotation->delete();
    }
}
