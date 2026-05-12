@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">
                Sale Details
            </h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">Invoice: <span class="font-bold text-indigo-600">#{{ $sale->invoice_no }}</span></p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('sales.index') }}">
                <x-button class="text-gray-700 border border-gray-200 hover:bg-gray-50 shadow-sm px-6 rounded-2xl font-bold">
                    Back
                </x-button>
            </a>
        </div>
    </div>

    {{-- Main Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        {{-- Customer --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
            <label class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Customer</label>
            <h3 class="text-lg font-black text-gray-800">{{ $sale->customer->name ?? 'Walk-in Customer' }}</h3>
            <p class="text-sm text-gray-400 mt-1">{{ $sale->customer->phone ?? 'No contact info' }}</p>
        </x-card>

        {{-- Date --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
            <label class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Sale Date</label>
            <h3 class="text-lg font-black text-gray-800">{{ date('d M Y', strtotime($sale->sale_date)) }}</h3>
            <p class="text-sm text-gray-400 mt-1">{{ date('h:i A', strtotime($sale->created_at)) }}</p>
        </x-card>

        {{-- Payment Status --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
            <label class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Payment Status</label>
            <span class="inline-block px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest 
                {{ $sale->payment_status === 'paid' ? 'bg-green-50 text-green-600 border border-green-100' : 
                   ($sale->payment_status === 'partial' ? 'bg-orange-50 text-orange-600 border border-orange-100' : 'bg-red-50 text-red-600 border border-red-100') }}">
                {{ $sale->payment_status }}
            </span>
        </x-card>

        {{-- Total --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8 bg-indigo-50/50 border border-indigo-100">
            <label class="block mb-2 text-xs font-black text-indigo-400 uppercase tracking-widest">Grand Total</label>
            <h3 class="text-2xl font-black text-indigo-600">₹{{ number_format($sale->total, 2) }}</h3>
        </x-card>

    </div>

    {{-- Sale Items Table --}}
    <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 text-left border-b border-gray-100">
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product Details</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Qty</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Unit Price</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($sale->items as $item)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-gray-800 text-sm tracking-tight">{{ $item->product->name }}</h4>
                                        @if($item->variation)
                                            <span class="inline-block mt-1 px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-tighter rounded-md border border-indigo-100">
                                                Variant: {{ $item->variation }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 rounded-lg font-black text-sm">{{ $item->quantity }}</span>
                            </td>
                            <td class="p-6 text-right font-bold text-gray-600 text-sm tracking-tight">₹{{ number_format($item->price, 2) }}</td>
                            <td class="p-6 text-right font-black text-gray-800 text-sm tracking-tight">₹{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Bottom Section --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-20">
        
        {{-- Notes & Payment Info --}}
        <div class="md:col-span-7 space-y-8">
            @if($sale->note)
                <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
                    <label class="block mb-4 text-xs font-black text-gray-400 uppercase tracking-widest">Sale Note</label>
                    <p class="text-gray-600 leading-relaxed italic text-sm">"{{ $sale->note }}"</p>
                </x-card>
            @endif

            <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
                <label class="block mb-6 text-xs font-black text-gray-400 uppercase tracking-widest">Payment Breakdown</label>
                <div class="grid grid-cols-2 gap-8">
                    <div class="p-6 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Amount Paid</p>
                        <h4 class="text-xl font-black text-indigo-600">₹{{ number_format($sale->paid_amount, 2) }}</h4>
                    </div>
                    <div class="p-6 bg-red-50/50 rounded-2xl border border-red-100">
                        <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Due Balance</p>
                        <h4 class="text-xl font-black text-red-600">₹{{ number_format($sale->due_amount, 2) }}</h4>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Final Calculations --}}
        <div class="md:col-span-5">
            <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8 space-y-6">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Subtotal</span>
                    <span class="font-black text-gray-700 tracking-tight">₹{{ number_format($sale->subtotal, 2) }}</span>
                </div>
                
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Discount</span>
                    <span class="font-black text-red-500 tracking-tight">- ₹{{ number_format($sale->discount, 2) }}</span>
                </div>

                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Tax (VAT)</span>
                    <span class="font-black text-gray-700 tracking-tight">+ ₹{{ number_format($sale->tax, 2) }}</span>
                </div>

                <div class="h-px bg-gray-50 w-full"></div>

                <div class="flex justify-between items-center pt-2">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-xs">Total Amount</span>
                    <span class="text-3xl font-black text-indigo-600 tracking-tighter">₹{{ number_format($sale->total, 2) }}</span>
                </div>
            </x-card>
        </div>

    </div>

</div>

@endsection
