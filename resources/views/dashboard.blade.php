@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard
            </h1>

        </div>

        <div class="relative inline-block text-left" id="dateFilterDropdown">
            <div>
                <button type="button" class="inline-flex items-center justify-center w-full rounded-xl border border-gray-200 shadow-sm px-6 py-3 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all gap-2" id="date-filter-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span id="current-range-text">
                        {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                    </span>
                    <svg class="-mr-1 ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="hidden origin-top-right absolute right-0 mt-2 w-64 rounded-2xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50 focus:outline-none divide-y divide-gray-100" id="date-filter-menu">
                <div class="py-2 px-1">
                    <button onclick="setDateRange('today')" class="group flex items-center w-full px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">Today</button>
                    <button onclick="setDateRange('this_week')" class="group flex items-center w-full px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">This Week</button>
                    <button onclick="setDateRange('last_week')" class="group flex items-center w-full px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">Last Week</button>
                    <button onclick="setDateRange('this_month')" class="group flex items-center w-full px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">This Month</button>
                    <button onclick="setDateRange('last_month')" class="group flex items-center w-full px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">Last Month</button>
                </div>
                <div class="p-4 bg-gray-50 rounded-b-2xl">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Custom Range</p>
                    <form action="{{ route('dashboard') }}" method="GET" class="space-y-3">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 ml-1">START DATE</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 ml-1">END DATE</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 transition shadow-md shadow-blue-200 active:scale-95">Apply Filter</button>
                        <a href="{{ route('dashboard') }}" class="block w-full text-center py-2 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Reset</a>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

        {{-- Total Sales --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-default">
            <a href="/sales" class="cursor-pointer">

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Total Sales</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    ₹{{ number_format($totalSales, 2) }}
                </h2>

            </a>
        </div>

        {{-- Purchases --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-default">

            <a href="/purchases" class="cursor-pointer">

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Purchases</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    ₹{{ number_format($totalPurchases, 2) }}
                </h2>

            </a>

        </div>

        {{-- Products --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-default">

            <a href="/products" class="cursor-pointer">

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Products</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $totalProducts }}
                </h2>
            </a>

        </div>

        {{-- Customers --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-default">

            <a href="/customers" class="cursor-pointer">

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Customers</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $totalCustomers }}
                </h2>
            </a>

        </div>

        {{-- Suppliers --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-default">

            <a href="/suppliers" class="cursor-pointer">

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Suppliers</p>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $totalSuppliers }}
                </h2>
            </a>

        </div>
        
    </div>
    
    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Top Selling Products --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <h2 class="text-lg font-bold text-gray-800 mb-6 text-center flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Top Selling Products ({{ date('Y') }})
            </h2>
            <div class="relative h-[300px]">
                @if($topSellingProducts->count() > 0)
                    <canvas id="productsChart"></canvas>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 italic">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        No sales data yet
                    </div>
                @endif
            </div>
        </div>

        {{-- Top Customers --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <h2 class="text-lg font-bold text-gray-800 mb-6 text-center flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Top 5 Customers ({{ date('F') }})
            </h2>
            <div class="relative h-[300px]">
                @if($topCustomers->count() > 0)
                    <canvas id="customersChart"></canvas>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 italic">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        No customer data yet
                    </div>
                @endif
            </div>
        </div>

    </div>
    
    {{-- Weekly Sales & Purchases Chart --}}
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl font-bold text-gray-800">This Week Sales & Purchases</h2>
                <p class="text-sm text-gray-500 mt-1">Daily overview of your business transactions</p>
            </div>
            <div class="flex bg-gray-100 p-1 rounded-xl">
                <button onclick="updateChartType('bar')" id="btn-bar" class="px-4 py-2 rounded-lg text-sm font-bold transition bg-white text-blue-600 shadow-sm">Bar</button>
                <button onclick="updateChartType('line')" id="btn-line" class="px-4 py-2 rounded-lg text-sm font-bold transition text-gray-500 hover:bg-gray-200">Line</button>
            </div>
        </div>
        <div class="relative h-[400px]">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>


    {{-- Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Sales --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    Recent Sales
                </h2>
                <a href="{{ route('sales.index') }}" class="text-sm text-blue-600 font-medium hover:underline">View All</a>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50/50">

                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Invoice</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Total</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($recentSales as $sale)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                    {{ $sale->invoice_no }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $sale->customer->name ?? 'Walk-in' }}
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                    ₹{{ number_format($sale->total, 2) }}
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500 text-sm italic">
                                    No sales found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Recent Purchases --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Recent Purchases
                </h2>
                <a href="{{ route('purchases.index') }}" class="text-sm text-blue-600 font-medium hover:underline">View All</a>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50/50">

                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Invoice</th>
                            <th class="px-6 py-3">Supplier</th>
                            <th class="px-6 py-3">Total</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($recentPurchases as $purchase)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                    {{ $purchase->invoice_no }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $purchase->supplier->name ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-blue-600">
                                    ₹{{ number_format($purchase->total, 2) }}
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500 text-sm italic">
                                    No purchases found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Low Stock --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-lg font-bold text-red-600 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Low Stock Products
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50/50">

                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Product Name</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3 text-center">Available Stock</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($lowStockProducts as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $product->category_name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @can('create_purchase')
                                <a href="{{ route('purchases.create') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1 rounded-lg transition">
                                    Restock
                                </a>
                                @endcan
                            </td>
                        </tr>
                    @empty

                        <tr>

                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 text-sm italic">
                                Great! All products are in good stock.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Date Filter Logic
    const filterBtn = document.getElementById('date-filter-button');
    const filterMenu = document.getElementById('date-filter-menu');

    filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        filterMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!filterMenu.contains(e.target) && !filterBtn.contains(e.target)) {
            filterMenu.classList.add('hidden');
        }
    });

    window.setDateRange = function(range) {
        let start, end;
        const today = new Date();
        
        switch(range) {
            case 'today':
                start = end = formatDate(today);
                break;
            case 'this_week':
                const first = today.getDate() - today.getDay();
                start = formatDate(new Date(today.setDate(first)));
                end = formatDate(new Date());
                break;
            case 'last_week':
                const lastWeekFirst = today.getDate() - today.getDay() - 7;
                const lastWeekLast = today.getDate() - today.getDay() - 1;
                start = formatDate(new Date(today.setDate(lastWeekFirst)));
                end = formatDate(new Date(new Date().setDate(lastWeekLast)));
                break;
            case 'this_month':
                start = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
                end = formatDate(new Date(today.getFullYear(), today.getMonth() + 1, 0));
                break;
            case 'last_month':
                start = formatDate(new Date(today.getFullYear(), today.getMonth() - 1, 1));
                end = formatDate(new Date(today.getFullYear(), today.getMonth(), 0));
                break;
        }

        window.location.href = `{{ route('dashboard') }}?start_date=${start}&end_date=${end}`;
    };

    function formatDate(date) {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    // Weekly Sales & Purchases Chart
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        
        // Create Gradients
        const salesGradient = weeklyCtx.createLinearGradient(0, 0, 0, 400);
        salesGradient.addColorStop(0, 'rgba(85, 110, 230, 0.8)');
        salesGradient.addColorStop(1, 'rgba(85, 110, 230, 0.2)');

        const purchaseGradient = weeklyCtx.createLinearGradient(0, 0, 0, 400);
        purchaseGradient.addColorStop(0, 'rgba(52, 195, 143, 0.8)');
        purchaseGradient.addColorStop(1, 'rgba(52, 195, 143, 0.2)');

        let weeklyChart = new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [
                    {
                        label: 'Sales',
                        data: {!! json_encode(array_values(array_map('floatval', $weeklySales))) !!},
                        backgroundColor: salesGradient,
                        borderColor: '#556ee6',
                        borderWidth: 1,
                        borderRadius: 8,
                        tension: 0,
                        pointRadius: 0,
                        fill: true
                    },
                    {
                        label: 'Purchases',
                        data: {!! json_encode(array_values(array_map('floatval', $weeklyPurchases))) !!},
                        backgroundColor: purchaseGradient,
                        borderColor: '#34c38f',
                        borderWidth: 1,
                        borderRadius: 8,
                        tension: 0,
                        pointRadius: 0,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'center',
                        labels: {
                            usePointStyle: true,
                            padding: 25,
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'nearest',
                        intersect: true,
                        padding: 12,
                        backgroundColor: '#3e3e42bd',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#1e1e2d',
                        borderWidth: 1,
                        displayColors: true,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ' : ₹' + new Intl.NumberFormat().format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5],
                            color: '#F3F4F6'
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                if (value >= 1000) return '₹' + (value / 1000) + 'k';
                                return '₹' + value;
                            }
                        }
                    }
                }
            }
        });

        // Toggle Chart Type
        window.updateChartType = function(type) {
            weeklyChart.config.type = type;
            
            // Update button styles
            const btnBar = document.getElementById('btn-bar');
            const btnLine = document.getElementById('btn-line');
            
            if (type === 'bar') {
                btnBar.className = 'px-4 py-2 rounded-lg text-sm font-bold transition bg-white text-blue-600 shadow-sm';
                btnLine.className = 'px-4 py-2 rounded-lg text-sm font-bold transition text-gray-500 hover:bg-gray-200';
                
                weeklyChart.data.datasets.forEach(dataset => {
                    dataset.borderRadius = 8;
                    dataset.fill = true;
                    dataset.tension = 0;
                    dataset.pointRadius = 0;
                });
            } else {
                btnLine.className = 'px-4 py-2 rounded-lg text-sm font-bold transition bg-white text-blue-600 shadow-sm';
                btnBar.className = 'px-4 py-2 rounded-lg text-sm font-bold transition text-gray-500 hover:bg-gray-200';
                
                weeklyChart.data.datasets.forEach((dataset, index) => {
                    dataset.borderRadius = 0;
                    dataset.fill = true;
                    dataset.tension = 0.4;
                    dataset.pointRadius = 4;
                    dataset.pointHoverRadius = 6;
                    dataset.pointBackgroundColor = '#ffffff';
                    dataset.pointBorderColor = index === 0 ? '#556ee6' : '#34c38f';
                    dataset.pointBorderWidth = 2;
                });
            }
            
            weeklyChart.update();
        };

        // Shared Chart Config
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: 10
            },
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            family: "'Inter', sans-serif",
                            size: 12,
                            weight: '500'
                        },
                        color: '#4B5563'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1F2937',
                    bodyColor: '#4B5563',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.dataset.label === 'Amount') {
                                label += '₹' + new Intl.NumberFormat().format(context.parsed);
                            } else {
                                label += new Intl.NumberFormat().format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        };

        // Products Chart
        const productsCtx = document.getElementById('productsChart');
        if (productsCtx) {
            new Chart(productsCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($topSellingProducts->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode($topSellingProducts->pluck('total_qty')) !!},
                        backgroundColor: [
                            '#556ee6', // primary
                            '#34c38f', // success
                            '#f1b44c', // warning
                            '#f46a6a', // danger
                            '#50a5f1'  // info
                        ],
                        hoverOffset: 15,
                        borderWidth: 4,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    ...chartOptions,
                    cutout: '65%'
                }
            });
        }

        // Customers Chart
        const customersCtx = document.getElementById('customersChart');
        if (customersCtx) {
            new Chart(customersCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($topCustomers->pluck('customer_name')) !!},
                    datasets: [{
                        label: 'Amount',
                        data: {!! json_encode($topCustomers->pluck('total_amount')) !!},
                        backgroundColor: [
                            '#556ee6',
                            '#34c38f',
                            '#f1b44c',
                            '#f46a6a',
                            '#50a5f1'
                        ],
                        hoverOffset: 15,
                        borderWidth: 4,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    ...chartOptions,
                    cutout: '65%'
                }
            });
        }
    });
</script>
@endpush