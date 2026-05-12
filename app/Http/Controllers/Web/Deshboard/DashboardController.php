<?php

namespace App\Http\Controllers\Web\Deshboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalSales = Sale::sum('total');
        $totalPurchases = Purchase::sum('total');
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();

        // Today's Stats
        $todaySales = Sale::whereDate('sale_date', Carbon::today())->sum('total');
        $todayPurchases = Purchase::whereDate('purchase_date', Carbon::today())->sum('total');

        // Comprehensive Low Stock Logic (including variations)
        $allProducts = Product::with('category')->where('status', 1)->get();
        $lowStockItems = collect();

        foreach ($allProducts as $product) {
            if ($product->product_type === 'variation' && !empty($product->variations)) {
                foreach ($product->variations as $vName => $vData) {
                    $stock = (int)($vData['opening_stock'] ?? 0);
                    $alert = (int)($vData['stock_alert'] ?? 10);
                    
                    if ($stock <= $alert) {
                        $lowStockItems->push((object)[
                            'id' => $product->id,
                            'name' => $product->name . " ($vName)",
                            'category_name' => optional($product->category)->name ?? 'N/A',
                            'stock' => $stock,
                            'alert' => $alert
                        ]);
                    }
                }
            } else {
                if ($product->current_stock <= $product->stock_alert) {
                    $lowStockItems->push((object)[
                        'id' => $product->id,
                        'name' => $product->name,
                        'category_name' => optional($product->category)->name ?? 'N/A',
                        'stock' => $product->current_stock,
                        'alert' => $product->stock_alert
                    ]);
                }
            }
        }

        $lowStockProducts = $lowStockItems->take(10);

        // Recent Sales with Customer Info
        $recentSales = Sale::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Recent Purchases with Supplier Info
        $recentPurchases = Purchase::with('supplier')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSales',
            'totalPurchases',
            'totalProducts',
            'totalCustomers',
            'totalSuppliers',
            'todaySales',
            'todayPurchases',
            'lowStockProducts',
            'recentSales',
            'recentPurchases'
        ));
    }
}
