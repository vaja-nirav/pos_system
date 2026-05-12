@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">
                Stock Report
            </h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">Detailed inventory overview across all products</p>
        </div>
    </div>

    <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 text-left border-b border-gray-100">
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product Info</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">SKU</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Available Stock</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                    </tr>
                </thead>
                @foreach($products as $product)
                    @php
                        $isVariation = $product->product_type === 'variation';
                        $variations = $product->variations ?? [];
                    @endphp

                    <tbody x-data="{ open: false }" class="divide-y divide-gray-50 border-t border-gray-50 first:border-t-0">
                        {{-- Main Product Row --}}
                        <tr class="{{ $isVariation ? 'bg-gray-50/20' : '' }} hover:bg-gray-50/30 transition-colors">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    @if($isVariation)
                                        <button 
                                            @click="open = !open"
                                            class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm active:scale-95"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </button>
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-black text-gray-800 text-sm tracking-tight">{{ $product->name }}</h4>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $isVariation ? 'Variation Product' : 'Single Product' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg">{{ $product->sku }}</span>
                            </td>
                            <td class="p-6 text-center">
                                @if(!$isVariation)
                                    <span class="inline-block px-4 py-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl text-xs font-black shadow-sm">
                                        {{ $product->current_stock }}
                                    </span>
                                @else
                                    <span class="inline-block px-4 py-2 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-xl text-[10px] font-black uppercase tracking-tighter shadow-sm">
                                        Multiple Variants
                                    </span>
                                @endif
                            </td>
                            <td class="p-6">
                                @if(!$isVariation)
                                    @include('reports.partials.stock_status', [
                                        'stock' => $product->current_stock,
                                        'alert' => $product->stock_alert
                                    ])
                                @else
                                    <button @click="open = !open" class="text-[10px] font-black text-indigo-500 uppercase tracking-widest hover:text-indigo-700 transition-colors flex items-center gap-2">
                                        <span x-text="open ? 'Hide Breakdown' : 'Show Breakdown'"></span>
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- Variation Sub-rows --}}
                        @if($isVariation)
                            @foreach($variations as $vName => $vData)
                                <tr 
                                    x-show="open" 
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="bg-white hover:bg-indigo-50/10 transition-colors"
                                >
                                    <td class="p-6 pl-16">
                                        <div class="flex items-center gap-3">
                                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                                            <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">{{ $vName }}</span>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-[10px] font-bold text-gray-400 tracking-wider">{{ $vData['sku'] ?? 'N/A' }}</span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="inline-block px-3 py-1.5 bg-gray-50 text-gray-700 border border-gray-100 rounded-lg text-xs font-black">
                                            {{ $vData['opening_stock'] ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="p-6">
                                        @include('reports.partials.stock_status', [
                                            'stock' => $vData['opening_stock'] ?? 0,
                                            'alert' => $vData['stock_alert'] ?? 10
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-gray-50">
            {{ $products->links() }}
        </div>
    </x-card>

</div>

@endsection