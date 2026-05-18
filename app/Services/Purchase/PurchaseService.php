<?php

namespace App\Services\Purchase;

use App\Models\Product;
use App\Models\PurchaseItem;
use App\Repositories\Purchase\PurchaseRepository;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function getAll()
    {
        return $this->purchaseRepository->getAll();
    }

    public function findById($id)
    {
        return $this->purchaseRepository->findById($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            // Purchase Create
            $purchase = $this->purchaseRepository->store([
                'supplier_id' => $request->supplier_id,
                'invoice_no' => $request->invoice_no,
                'purchase_date' => $request->purchase_date,
                'subtotal' => $request->subtotal,
                'tax' => $request->tax ?? 0,
                'discount' => $request->discount ?? 0,
                'total' => $request->total,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,
                'payment_status' => $request->payment_status,
                'status' => $request->status,
            ]);

            // Purchase Items
            foreach ($request->products as $item) {
                $variationName = ! empty($item['variation']) ? trim($item['variation']) : null;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'variation' => $variationName,
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'total' => $item['total'],
                ]);

                // Increase Stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $qty = (int) $item['quantity'];
                    if ($product->product_type === 'variation' && $variationName) {
                        $variations = $product->variations;
                        $matchKey = null;
                        foreach ($variations as $key => $v) {
                            if (strtolower(trim($key)) === strtolower($variationName)) {
                                $matchKey = $key;
                                break;
                            }
                        }

                        if ($matchKey) {
                            $variations[$matchKey]['opening_stock'] = (int) ($variations[$matchKey]['opening_stock'] ?? 0) + $qty;
                            $product->variations = $variations;

                            // Sync Total
                            $totalStock = 0;
                            foreach ($variations as $v) {
                                $totalStock += (int) ($v['opening_stock'] ?? 0);
                            }
                            $product->current_stock = $totalStock;
                        } else {
                            $product->current_stock = (int) $product->current_stock + $qty;
                        }
                    } else {
                        $product->current_stock = (int) $product->current_stock + $qty;
                    }
                    $product->save();
                }
            }

            DB::commit();

            return $purchase;
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $purchase = $this->purchaseRepository->findById($id);

            // Revert old stock impacts
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $qty = (int) $item->quantity;
                    $variationName = ! empty($item->variation) ? trim($item->variation) : null;

                    if ($product->product_type === 'variation' && $variationName) {
                        $variations = $product->variations;
                        $matchKey = null;
                        foreach ($variations as $key => $v) {
                            if (strtolower(trim($key)) === strtolower($variationName)) {
                                $matchKey = $key;
                                break;
                            }
                        }

                        if ($matchKey) {
                            $variations[$matchKey]['opening_stock'] = (int) ($variations[$matchKey]['opening_stock'] ?? 0) - $qty;
                            $product->variations = $variations;

                            // Sync Total
                            $totalStock = 0;
                            foreach ($variations as $v) {
                                $totalStock += (int) ($v['opening_stock'] ?? 0);
                            }
                            $product->current_stock = $totalStock;
                        } else {
                            $product->current_stock = (int) $product->current_stock - $qty;
                        }
                    } else {
                        $product->current_stock = (int) $product->current_stock - $qty;
                    }
                    $product->save();
                }
            }

            // Delete old items
            $purchase->items()->delete();

            // Update Purchase
            $this->purchaseRepository->update($id, [
                'supplier_id' => $request->supplier_id,
                'invoice_no' => $request->invoice_no,
                'purchase_date' => $request->purchase_date,
                'subtotal' => $request->subtotal,
                'tax' => $request->tax ?? 0,
                'discount' => $request->discount ?? 0,
                'total' => $request->total,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,
                'payment_status' => $request->payment_status,
                'status' => $request->status,
            ]);

            // Create New Items and Apply Stock
            foreach ($request->products as $item) {
                $variationName = ! empty($item['variation']) ? trim($item['variation']) : null;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'variation' => $variationName,
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'total' => $item['total'],
                ]);

                // Increase Stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $qty = (int) $item['quantity'];
                    if ($product->product_type === 'variation' && $variationName) {
                        $variations = $product->variations;
                        $matchKey = null;
                        foreach ($variations as $key => $v) {
                            if (strtolower(trim($key)) === strtolower($variationName)) {
                                $matchKey = $key;
                                break;
                            }
                        }

                        if ($matchKey) {
                            $variations[$matchKey]['opening_stock'] = (int) ($variations[$matchKey]['opening_stock'] ?? 0) + $qty;
                            $product->variations = $variations;

                            // Sync Total
                            $totalStock = 0;
                            foreach ($variations as $v) {
                                $totalStock += (int) ($v['opening_stock'] ?? 0);
                            }
                            $product->current_stock = $totalStock;
                        } else {
                            $product->current_stock = (int) $product->current_stock + $qty;
                        }
                    } else {
                        $product->current_stock = (int) $product->current_stock + $qty;
                    }
                    $product->save();
                }
            }

            DB::commit();

            return $purchase;
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $purchase = $this->purchaseRepository->findById($id);

            // Revert stock
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $qty = (int) $item->quantity;
                    $variationName = ! empty($item->variation) ? trim($item->variation) : null;

                    if ($product->product_type === 'variation' && $variationName) {
                        $variations = $product->variations;
                        $matchKey = null;
                        foreach ($variations as $key => $v) {
                            if (strtolower(trim($key)) === strtolower($variationName)) {
                                $matchKey = $key;
                                break;
                            }
                        }

                        if ($matchKey) {
                            $variations[$matchKey]['opening_stock'] = (int) ($variations[$matchKey]['opening_stock'] ?? 0) - $qty;
                            $product->variations = $variations;

                            // Sync Total
                            $totalStock = 0;
                            foreach ($variations as $v) {
                                $totalStock += (int) ($v['opening_stock'] ?? 0);
                            }
                            $product->current_stock = $totalStock;
                        } else {
                            $product->current_stock = (int) $product->current_stock - $qty;
                        }
                    } else {
                        $product->current_stock = (int) $product->current_stock - $qty;
                    }
                    $product->save();
                }
            }

            // Delete Purchase
            $this->purchaseRepository->delete($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
