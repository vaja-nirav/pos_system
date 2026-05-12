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

        <div class="flex gap-3">

            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-sm font-medium">
                Today's Sales: ₹{{ number_format($todaySales, 2) }}
            </div>

            <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl text-sm font-medium">
                Today's Purchases: ₹{{ number_format($todayPurchases, 2) }}
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