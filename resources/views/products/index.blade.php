@extends('layouts.app')

@section('content')

<div x-data="{ showImportModal: false, showFilter: false }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Products</h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">Manage and track your product inventory</p>
        </div>

        <div class="flex items-center gap-4 relative">
            {{-- Filter Button --}}
            <button 
                @click="showFilter = !showFilter"
                class="w-12 h-12 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm border border-indigo-100"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
            </button>

            @can('create_products')
                <a href="{{ route('products.create') }}">
                    <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 rounded-2xl font-bold shadow-lg shadow-indigo-100">
                        + Create Product
                    </x-button>
                </a>
            @endcan

            {{-- Filter Dropdown --}}
            <div 
                x-show="showFilter" 
                @click.away="showFilter = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="absolute right-0 top-16 w-80 bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 z-50 p-6 space-y-5"
                style="display: none;"
            >

                <div class="space-y-3 pt-2">
                    @can('create_products')
                        <a href="{{ route('products.export') }}" class="w-full py-3 bg-indigo-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-100">
                            Export Products
                        </a>
                        <button @click="showImportModal = true; showFilter = false" class="w-full py-3 bg-indigo-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-100">
                            Import Products
                        </button>
                    @endcan
                    <button @click="showFilter = false" class="w-full py-3 bg-gray-100 text-gray-500 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center hover:bg-gray-200 transition-all">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl">
        <x-table>
            <thead class="bg-gray-50/50">
                <tr class="text-left border-b border-gray-100">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Image</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Category</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Brand</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Unit</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Price</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50/30 transition-all group">
                        <td class="px-8 py-5">
                            @php $imgUrl = $product->getFirstMediaUrl('products'); @endphp
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" class="w-14 h-14 rounded-2xl object-cover shadow-sm border border-gray-100 group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-gray-100 border border-gray-50 flex items-center justify-center text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800 text-sm tracking-tight">{{ $product->name }}</span>
                                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-0.5">SKU: {{ $product->sku }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black tracking-wider">{{ $product->category->name }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-gray-600 decoration-gray-200 decoration-2 underline-offset-4">{{ $product->brand?->name ?? 'Generic' }}</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="w-10 h-10 flex items-center justify-center text-gray-500 rounded-xl text-[10px] font-black">{{ $product->unit->short_name }}</span>
                        </td>
                        <td class="px-8 py-5">
                            @if($product->product_type === 'variation' && is_array($product->variations))
                                @php
                                    $prices = array_column($product->variations, 'price');
                                    $minPrice = count($prices) ? min($prices) : 0;
                                    $maxPrice = count($prices) ? max($prices) : 0;
                                @endphp
                                <div class="font-black text-gray-800 text-xs">
                                    ₹{{ number_format($minPrice, 2) }} - ₹{{ number_format($maxPrice, 2) }}
                                </div>
                            @else
                                <div class="font-black text-gray-800 text-xs decoration-indigo-200">
                                    ₹{{ number_format($product->selling_price, 2) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            @if($product->status)
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-green-600 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Active
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-red-500 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Inactive
                                </span>
                            @endif
                        </td>

                    {{-- Action --}}
                    <td class="p-4 text-center">

                        <div
                            x-data="{ openActionMenu: false, openDeleteModal: false }"
                            class="relative inline-block text-left"
                        >

                            {{-- 3 Dot Button --}}
                            <button
                                @click="openActionMenu = !openActionMenu"
                                class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition border border-gray-200"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-gray-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 5h.01M12 12h.01M12 19h.01"
                                    />
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div
                                x-show="openActionMenu"
                                @click.away="openActionMenu = false"
                                x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border z-50 overflow-hidden"
                                style="display: none;"
                            >

                                {{-- Edit --}}
                                @can('update_products')
                                    <a
                                        href="{{ route('products.edit', $product->id) }}"
                                        class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition"
                                    >
                                        <span class="font-medium text-gray-700">
                                            Edit Product
                                        </span>
                                    </a>
                                @endcan

                                {{-- Barcode --}}
                                <button
                                    @click="
                                        openActionMenu = false;
                                        $dispatch('open-barcode', '{{ route('products.barcode', $product->id) }}');
                                    "
                                    class="w-full flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition text-left"
                                >
                                    <span class="font-medium text-gray-700">
                                        View Barcode
                                    </span>
                                </button>

                                {{-- Delete --}}
                                @can('delete_products')
                                    <button
                                        @click="
                                            openDeleteModal = true;
                                            openActionMenu = false;
                                        "
                                        class="w-full flex items-center gap-3 px-5 py-3 hover:bg-red-50 text-red-500 transition text-left"
                                    >
                                        <span class="font-medium">
                                            Delete Product
                                        </span>
                                    </button>
                                @endcan

                                </div>

                                {{-- Delete Modal --}}
                            <div
                                x-show="openDeleteModal"
                                class="fixed inset-0 flex items-center justify-center bg-black/50 z-[60]"
                                style="display: none;"
                            >

                                <div
                                    @click.away="openDeleteModal = false"
                                    class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6"
                                >

                                    <h2 class="text-xl font-bold text-gray-800 mb-3 text-left">
                                        Delete Product
                                    </h2>

                                    <p class="text-gray-500 mb-6 text-left">
                                        Are you sure you want to delete this product?
                                    </p>

                                    <div class="flex justify-end gap-3">

                                        <button
                                            @click="openDeleteModal = false"
                                            class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition"
                                        >
                                            Cancel
                                        </button>

                                        <form
                                            action="{{ route('products.destroy', $product->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                                            >
                                                Delete
                                            </button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg></div>
                                <p class="text-gray-400 font-black text-xs uppercase tracking-[0.2em]">No Products Available</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>

        @if($products->hasPages())
            <div class="px-8 py-6 bg-gray-50/30 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @endif
    </x-card>

    {{-- Import Modal --}}
    <div 
        x-show="showImportModal" 
        class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-md z-[100]" 
        style="display: none;"
    >
        <div 
            @click.away="showImportModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 translate-y-10"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl relative overflow-hidden flex flex-col max-h-[90vh]"
        >
            {{-- Header --}}
            <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-white sticky top-0 z-10">
                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Import Products</h2>
                <button @click="showImportModal = false" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-full hover:bg-red-50 hover:text-red-500 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Content --}}
            <div class="p-8 overflow-y-auto">
                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex-1 border-2 border-dashed border-gray-200 rounded-2xl p-2 bg-gray-50/50 hover:border-indigo-400 hover:bg-indigo-50/20 transition-all group">
                            <input type="file" name="file" required class="w-full text-xs font-bold text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-white file:text-indigo-600 file:shadow-sm hover:file:bg-indigo-50 transition-all cursor-pointer">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-10">
                        <button type="submit" class="flex-1 py-4 bg-indigo-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-indigo-100">Save</button>
                        <a href="{{ route('products.sample') }}" class="flex-1 py-4 bg-blue-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest text-center hover:bg-blue-600 transition-all shadow-xl shadow-blue-100">Download Sample</a>
                    </div>

                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Required & Optional Fields Guide</p>
                        
                        @php
                            $fields = [
                                'Name' => ['required' => true, 'desc' => 'Product title'],
                                'Product Code' => ['required' => true, 'desc' => 'SKU - must be unique'],
                                'Category' => ['required' => true, 'desc' => 'Full name of category'],
                                'Brand' => ['required' => false, 'desc' => 'Field optional'],
                                'Product Cost' => ['required' => true, 'desc' => 'Purchase price'],
                                'Product Price' => ['required' => true, 'desc' => 'Selling price'],
                                'Product Unit' => ['required' => true, 'desc' => 'Unit name must exist'],
                                'Sale Unit' => ['required' => true, 'desc' => ''],
                                'Purchase Unit' => ['required' => true, 'desc' => ''],
                                'Order Tax' => ['required' => false, 'desc' => 'Field optional'],
                                'Tax Type' => ['required' => true, 'desc' => ''],
                                'Stock Alert' => ['required' => false, 'desc' => 'Field optional'],
                                'Note' => ['required' => false, 'desc' => 'Field optional'],
                                'Warehouse' => ['required' => false, 'desc' => 'Field optional'],
                                'Supplier' => ['required' => false, 'desc' => 'Field optional'],
                                'Product Quantity' => ['required' => false, 'desc' => 'Field optional'],
                                'Status' => ['required' => false, 'desc' => 'Field optional'],
                                'Variation' => ['required' => false, 'desc' => 'For variation products only'],
                                'Variation Type' => ['required' => false, 'desc' => 'For variation products only'],
                            ];
                        @endphp

                        <div class="bg-gray-50/50 border border-gray-100 rounded-3xl overflow-hidden">
                            @foreach($fields as $label => $data)
                                <div class="flex items-center justify-between px-6 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                    <span class="text-xs font-bold text-gray-700">{{ $label }}</span>
                                    <div class="flex items-center gap-3">
                                        @if($data['required'])
                                            <span class="px-3 py-1 bg-indigo-50 text-indigo-500 rounded-lg text-[10px] font-medium uppercase tracking-tighter">This field is required</span>
                                        @else
                                            <span class="px-3 py-1 bg-green-50 text-green-500 rounded-lg text-[10px] font-medium uppercase tracking-tighter">Field optional</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="p-8 border-t border-gray-50 bg-gray-50/30 flex justify-end sticky bottom-0 z-10">
                <button @click="showImportModal = false" class="px-10 py-4 bg-gray-400 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-500 transition-all">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Barcode Modal (Iframe) -->
    <div x-data="{ showBarcodeModal: false, barcodeSrc: '' }" 
         @open-barcode.window="barcodeSrc = $event.detail; showBarcodeModal = true">
        <div
            x-show="showBarcodeModal"
            class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-[110]"
            style="display: none;"
        >
            <div
                @click.away="showBarcodeModal = false; barcodeSrc = ''"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-sm relative overflow-hidden"
            >
                <!-- Close Button -->
                <button
                    @click="showBarcodeModal = false; barcodeSrc = ''"
                    class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-500 rounded-full transition-all z-10"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <iframe :src="barcodeSrc" class="w-full h-[450px] border-0" title="Product Barcode"></iframe>
            </div>
        </div>
    </div>
</div></div>

@endsection