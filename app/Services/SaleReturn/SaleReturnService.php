<?php

namespace App\Services\SaleReturn;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Support\Facades\DB;

class SaleReturnService
{
    /**
     * Get all sale returns with pagination.
     */
    public function getAll()
    {
        return SaleReturn::with('sale.customer', 'items.product')
            ->latest()
            ->paginate(15);
    }

    /**
     * Find a sale return by ID.
     */
    public function findById($id)
    {
        return SaleReturn::with('sale.customer', 'items.product')
            ->findOrFail($id);
    }

    /**
     * Store a new sale return and restore stock.
     * When items are returned by customer, stock increases.
     */
    public function store($request)
    {
        DB::transaction(function () use ($request) {

            $sale = Sale::with('items')->findOrFail($request->sale_id);

            // Build a map of saleItem by product_id for qty validation
            $saleItemMap = $sale->items->keyBy('product_id');

            $totalReturnAmount = 0;

            // Validate return qty vs sold qty & compute total
            foreach ($request->products as $item) {
                $productId = $item['product_id'];
                $returnQty = (int) $item['qty'];

                if ($returnQty <= 0) {
                    continue;
                }

                if (isset($saleItemMap[$productId])) {
                    $soldQty = $saleItemMap[$productId]->quantity;
                    if ($returnQty > $soldQty) {
                        throw new \Exception(
                            "Return quantity ({$returnQty}) exceeds sold quantity ({$soldQty}) for product ID {$productId}."
                        );
                    }
                }

                $totalReturnAmount += $returnQty * $item['price'];
            }

            $return = SaleReturn::create([
                'sale_id'     => $sale->id,
                'return_no'   => 'SR-' . strtoupper(substr(uniqid(), -6)),
                'return_date' => $request->return_date,
                'total'       => $totalReturnAmount,
                'note'        => $request->note,
            ]);

            foreach ($request->products as $item) {
                $returnQty = (int) $item['qty'];

                if ($returnQty <= 0) {
                    continue;
                }

                $product = Product::findOrFail($item['product_id']);

                $return->items()->create([
                    'product_id' => $product->id,
                    'qty'        => $returnQty,
                    'price'      => $item['price'],
                    'subtotal'   => $returnQty * $item['price'],
                ]);

                // Restore stock — customer returned the items
                $product->increment('current_stock', $returnQty);
            }
        });
    }

    /**
     * Update an existing sale return.
     * Reverses old stock restorations, then applies new ones.
     */
    public function update($request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $return = SaleReturn::with('items')->findOrFail($id);

            // Step 1: Reverse old stock restorations (deduct what was previously restored)
            foreach ($return->items as $oldItem) {
                Product::where('id', $oldItem->product_id)
                    ->decrement('current_stock', $oldItem->qty);
            }

            // Step 2: Delete old items
            $return->items()->delete();

            // Step 3: Recalculate total
            $totalReturnAmount = 0;
            foreach ($request->products as $item) {
                $returnQty = (int) $item['qty'];
                if ($returnQty <= 0) continue;
                $totalReturnAmount += $returnQty * $item['price'];
            }

            // Step 4: Update return header
            $return->update([
                'return_date' => $request->return_date,
                'total'       => $totalReturnAmount,
                'note'        => $request->note,
            ]);

            // Step 5: Re-insert items and restore stock
            foreach ($request->products as $item) {
                $returnQty = (int) $item['qty'];
                if ($returnQty <= 0) continue;

                $product = Product::findOrFail($item['product_id']);

                $return->items()->create([
                    'product_id' => $product->id,
                    'qty'        => $returnQty,
                    'price'      => $item['price'],
                    'subtotal'   => $returnQty * $item['price'],
                ]);

                $product->increment('current_stock', $returnQty);
            }
        });
    }

    /**
     * Delete a sale return and reverse stock restoration.
     */
    public function delete($id)
    {
        DB::transaction(function () use ($id) {

            $return = SaleReturn::with('items')->findOrFail($id);

            // Deduct previously restored stock
            foreach ($return->items as $item) {
                Product::where('id', $item->product_id)
                    ->decrement('current_stock', $item->qty);
            }

            $return->delete();
        });
    }
}
