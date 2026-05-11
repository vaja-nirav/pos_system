<?php

namespace App\Services\PurchaseReturn;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use Illuminate\Support\Facades\DB;

class PurchaseReturnService
{
    /**
     * Get all purchase returns with pagination.
     */
    public function getAll()
    {
        return PurchaseReturn::with('purchase.supplier', 'items.product')
            ->latest()
            ->paginate(15);
    }

    /**
     * Find a purchase return by ID.
     */
    public function findById($id)
    {
        return PurchaseReturn::with('purchase.supplier', 'items.product')
            ->findOrFail($id);
    }

    /**
     * Store a new purchase return and adjust stock.
     */
    public function store($request)
    {
        DB::transaction(function () use ($request) {

            $purchase = Purchase::with('items')->findOrFail($request->purchase_id);

            // Build a map of purchaseItem by product_id for qty validation
            $purchaseItemMap = $purchase->items->keyBy('product_id');

            $totalReturnAmount = 0;

            // Validate return qty vs purchased qty & compute total
            foreach ($request->products as $item) {
                $productId = $item['product_id'];
                $returnQty = (int) $item['qty'];

                if ($returnQty <= 0) {
                    continue;
                }

                if (isset($purchaseItemMap[$productId])) {
                    $purchasedQty = $purchaseItemMap[$productId]->quantity;
                    if ($returnQty > $purchasedQty) {
                        throw new \Exception(
                            "Return quantity ({$returnQty}) exceeds purchased quantity ({$purchasedQty}) for product ID {$productId}."
                        );
                    }
                }

                $totalReturnAmount += $returnQty * $item['price'];
            }

            $return = PurchaseReturn::create([
                'purchase_id' => $purchase->id,
                'return_no'   => 'PR-' . strtoupper(substr(uniqid(), -6)),
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

                // Reduce stock because items are being returned to supplier
                $product->decrement('current_stock', $returnQty);
            }
        });
    }

    /**
     * Update an existing purchase return.
     * Reverses old stock changes, then applies new ones.
     */
    public function update($request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $return = PurchaseReturn::with('items')->findOrFail($id);

            // Step 1: Reverse old stock deductions
            foreach ($return->items as $oldItem) {
                Product::where('id', $oldItem->product_id)
                    ->increment('current_stock', $oldItem->qty);
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

            // Step 5: Re-insert items and deduct stock
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

                $product->decrement('current_stock', $returnQty);
            }
        });
    }

    /**
     * Delete a purchase return and restore stock.
     */
    public function delete($id)
    {
        DB::transaction(function () use ($id) {

            $return = PurchaseReturn::with('items')->findOrFail($id);

            // Restore stock
            foreach ($return->items as $item) {
                Product::where('id', $item->product_id)
                    ->increment('current_stock', $item->qty);
            }

            $return->delete();
        });
    }
}