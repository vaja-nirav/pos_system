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

        // Low Stock
        $lowStockProducts = Product::with('category')
            ->where('status', 1)
            ->whereColumn('current_stock', '<=', 'stock_alert')
            ->latest()
            ->take(10)
            ->get();

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
