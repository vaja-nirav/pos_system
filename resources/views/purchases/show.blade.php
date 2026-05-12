@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">
                Purchase Details
            </h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">
                Invoice: <span class="text-indigo-600 font-bold">#{{ $purchase->invoice_no }}</span>
            </p>
        </div>

        <a href="{{ route('purchases.index') }}">
            <x-button class="border border-gray-200 px-6 rounded-2xl font-bold">
                Back
            </x-button>
        </a>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-6">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Supplier</p>
            <h3 class="text-lg font-bold text-gray-800">{{ $purchase->supplier->name }}</h3>
        </x-card>

        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-6">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Purchase Date</p>
            <h3 class="text-lg font-bold text-gray-800">{{ date('d M Y', strtotime($purchase->purchase_date)) }}</h3>
        </x-card>

        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-6">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Payment Status</p>
            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm font-bold uppercase tracking-wider">
                {{ $purchase->payment_status }}
            </span>
        </x-card>

        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-6">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Amount</p>
            <h3 class="text-lg font-bold text-gray-800">₹{{ number_format($purchase->total, 2) }}</h3>
        </x-card>
    </div>

    {{-- Items Table --}}
    <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50">
                    <tr class="text-left border-b border-gray-100">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Qty</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Cost Price</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($purchase->items as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800">{{ $item->product->name }}</span>
                                    @if($item->variation)
                                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-0.5">
                                            {{ $item->variation }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="font-bold text-gray-600">{{ $item->quantity }}</span>
                            </td>
                            <td class="px-8 py-5 text-gray-600 font-medium italic">
                                ₹{{ number_format($item->cost_price, 2) }}
                            </td>
                            <td class="px-8 py-5 text-right font-bold text-gray-800">
                                ₹{{ number_format($item->total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Summary Totals --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-6">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Subtotal</p>
            <h3 class="text-xl font-bold text-gray-800">₹{{ number_format($purchase->subtotal, 2) }}</h3>
        </x-card>

        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-6">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tax</p>
            <h3 class="text-xl font-bold text-gray-800 text-indigo-500">₹{{ number_format($purchase->tax, 2) }}</h3>
        </x-card>

        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-6">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Discount</p>
            <h3 class="text-xl font-bold text-gray-800 text-indigo-500">₹{{ number_format($purchase->discount, 2) }}</h3>
        </x-card>

        <x-card class="border-none shadow-2xl shadow-green-100 rounded-3xl p-6 bg-green-50/30 border border-green-100">
            <p class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-1">Grand Total</p>
            <h3 class="text-3xl font-black text-green-600">₹{{ number_format($purchase->total, 2) }}</h3>
        </x-card>
    </div>

</div>

@endsection