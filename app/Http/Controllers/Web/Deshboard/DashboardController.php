<?php

namespace App\Http\Controllers\Web\Deshboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Default to this month if no dates provided
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Stats (Filtered by Date Range)
        $totalSales = Sale::whereBetween('sale_date', [$startDate, $endDate])->sum('total');
        $totalPurchases = Purchase::whereBetween('purchase_date', [$startDate, $endDate])->sum('total');
        $totalProducts = Product::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $totalCustomers = Customer::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $totalSuppliers = Supplier::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();

        // Keep Today's Stats for internal logic if needed, but they won't be shown in header
        $todaySales = Sale::whereDate('sale_date', Carbon::today())->sum('total') ?? 0;
        $todayPurchases = Purchase::whereDate('purchase_date', Carbon::today())->sum('total') ?? 0;

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

        // Top 5 Selling Products (Current Year)
        $topSellingProducts = SaleItem::query()
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_qty'))
            ->whereYear('sales.sale_date', Carbon::now()->year)
            ->when(Session::has('active_store_id'), function($q) {
                $q->where('sales.store_id', Session::get('active_store_id'));
            })
            ->groupBy('sale_items.product_id', 'products.name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Top 5 Customers (Current Month)
        $topCustomers = Sale::query()
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->select(DB::raw('COALESCE(customers.name, "Walk-in Customer") as customer_name'), DB::raw('SUM(sales.total) as total_amount'))
            ->whereMonth('sales.sale_date', Carbon::now()->month)
            ->whereYear('sales.sale_date', Carbon::now()->year)
            ->groupBy('sales.customer_id', 'customers.name')
            ->orderByDesc('total_amount')
            ->take(5)
            ->get();

        // Weekly Sales & Purchases Data
        $dates = [];
        $weeklySales = [];
        $weeklyPurchases = [];

        $chartStartDate = Carbon::now()->subDays(6)->startOfDay();
        $chartEndDate = Carbon::now()->endOfDay();

        // Fetch data in bulk for better performance and accuracy
        $salesData = Sale::whereBetween('sale_date', [$chartStartDate->format('Y-m-d'), $chartEndDate->format('Y-m-d')])
            ->select(DB::raw('sale_date, SUM(total) as daily_total'))
            ->groupBy('sale_date')
            ->pluck('daily_total', 'sale_date');

        $purchasesData = Purchase::whereBetween('purchase_date', [$chartStartDate->format('Y-m-d'), $chartEndDate->format('Y-m-d')])
            ->select(DB::raw('purchase_date, SUM(total) as daily_total'))
            ->groupBy('purchase_date')
            ->pluck('daily_total', 'purchase_date');

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayDate = Carbon::now()->subDays($i)->format('M d');
            
            $dates[] = $displayDate;
            $weeklySales[] = $salesData[$date] ?? 0;
            $weeklyPurchases[] = $purchasesData[$date] ?? 0;
        }

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
            'recentPurchases',
            'topSellingProducts',
            'topCustomers',
            'dates',
            'weeklySales',
            'weeklyPurchases',
            'startDate',
            'endDate'
        ));
    }
}
