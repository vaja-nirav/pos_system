@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tight">
                Quotation Details
            </h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">Ref No: <span class="font-bold text-indigo-600">#{{ $quotation->quotation_no }}</span></p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('quotations.index') }}">
                <button class="px-8 py-3.5 bg-white border border-gray-100 text-gray-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-50 transition-all shadow-sm">
                    Back to List
                </button>
            </a>
            @if($quotation->status == 'approved')
                <form action="{{ route('quotations.convert', $quotation->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
                        Convert to Sale
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Main Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Customer --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-[32px] p-8">
            <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Customer</label>
            <h3 class="text-lg font-black text-gray-800">{{ $quotation->customer->name ?? 'Walk-in Customer' }}</h3>
            <p class="text-sm text-gray-400 mt-1 font-medium">{{ $quotation->customer->phone ?? 'No contact info' }}</p>
        </x-card>

        {{-- Date --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-[32px] p-8">
            <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Quotation Date</label>
            <h3 class="text-lg font-black text-gray-800">{{ date('d M Y', strtotime($quotation->quotation_date)) }}</h3>
            <p class="text-sm text-gray-400 mt-1 font-medium">Valid until converted</p>
        </x-card>

        {{-- Status --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-[32px] p-8">
            <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Current Status</label>
            <span class="inline-flex px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border
                {{ $quotation->status === 'pending' ? 'bg-yellow-50 text-yellow-600 border-yellow-100' : 
                   ($quotation->status === 'approved' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-indigo-50 text-indigo-600 border-indigo-100') }}">
                {{ $quotation->status }}
            </span>
        </x-card>
    </div>

    {{-- Items Table --}}
    <x-card class="border-none shadow-xl shadow-gray-100 rounded-[40px] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 text-left border-b border-gray-100">
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product Details</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Quantity</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Unit Price</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Line Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($quotation->items as $item)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 border border-indigo-100 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-gray-800 text-sm tracking-tight">{{ $item->product->name }}</h4>
                                        @if($item->variation)
                                            <span class="inline-block mt-1 px-3 py-1 bg-white text-indigo-600 text-[9px] font-black uppercase tracking-widest rounded-lg border border-indigo-100 shadow-sm">
                                                Variant: {{ $item->variation }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <span class="inline-block px-4 py-2 bg-gray-50 text-gray-800 rounded-xl font-black text-sm border border-gray-100">{{ $item->quantity }}</span>
                            </td>
                            <td class="px-10 py-6 text-right font-bold text-gray-600 text-sm tracking-tight">₹{{ number_format($item->price, 2) }}</td>
                            <td class="px-10 py-6 text-right font-black text-gray-800 text-sm tracking-tight">₹{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Footer Summary --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-20">
        <div class="lg:col-span-8">
            <x-card class="border-none shadow-xl shadow-gray-100 rounded-[32px] p-10 h-full">
                <label class="block mb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Quotation Note</label>
                <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-100">
                    <p class="text-gray-600 leading-relaxed italic text-sm font-medium">
                        {{ $quotation->note ?: 'No special instructions provided for this estimate.' }}
                    </p>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-4">
            <x-card class="border-none shadow-xl shadow-gray-100 rounded-[32px] p-10 space-y-6">
                <div class="flex justify-between items-center text-sm font-bold">
                    <span class="text-gray-400 uppercase tracking-widest text-[10px]">Subtotal</span>
                    <span class="text-gray-800 tracking-tight">₹{{ number_format($quotation->subtotal, 2) }}</span>
                </div>
                
                <div class="flex justify-between items-center text-sm font-bold">
                    <span class="text-gray-400 uppercase tracking-widest text-[10px]">Discount</span>
                    <span class="text-red-500 tracking-tight">- ₹{{ number_format($quotation->discount, 2) }}</span>
                </div>

                <div class="flex justify-between items-center text-sm font-bold">
                    <span class="text-gray-400 uppercase tracking-widest text-[10px]">Tax Estimate</span>
                    <span class="text-gray-800 tracking-tight">+ ₹{{ number_format($quotation->tax, 2) }}</span>
                </div>

                <div class="h-px bg-gray-50 w-full my-4"></div>

                <div class="flex justify-between items-center pt-2">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px]">Grand Total</span>
                    <span class="text-3xl font-black text-indigo-600 tracking-tighter">₹{{ number_format($quotation->total, 2) }}</span>
                </div>
            </x-card>
        </div>
    </div>

</div>

@endsection
