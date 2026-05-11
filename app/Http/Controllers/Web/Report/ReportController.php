<?php

namespace App\Http\Controllers\Web\Report;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Sales Report
    public function salesReport(Request $request)
    {
        $query = Sale::query();

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('sale_date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $sales = $query->latest()->paginate(10);

        $totalSales = $query->sum('total');

        return view('reports.sales', compact(
            'sales',
            'totalSales'
        ));
    }

    // Purchase Report
    public function purchaseReport(Request $request)
    {
        $query = Purchase::query();

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('purchase_date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $purchases = $query->latest()->paginate(10);

        $totalPurchases = $query->sum('total');

        return view('reports.purchases', compact(
            'purchases',
            'totalPurchases'
        ));
    }

    // Stock Report
    public function stockReport()
    {
        $products = Product::latest()->paginate(10);

        return view('reports.stock', compact(
            'products'
        ));
    }

    // Profit Report
    public function profitReport()
    {
        $saleItems = SaleItem::with('product')
            ->latest()
            ->paginate(10);

        $totalProfit = 0;

        foreach ($saleItems as $item) {
            $purchasePrice =
                $item->product->purchase_price ?? 0;

            $salePrice =
                $item->price;

            $profit =
                ($salePrice - $purchasePrice)
                * $item->quantity;

            $totalProfit += $profit;

            $item->profit = $profit;
        }

        return view('reports.profit', compact(
            'saleItems',
            'totalProfit'
        ));
    }
}
