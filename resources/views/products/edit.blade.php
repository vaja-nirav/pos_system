@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Edit Product</h1>
        <p class="text-gray-500 text-sm tracking-wide">Update details for {{ $product->name }}</p>
    </div>
    <a href="{{ route('products.index') }}">
        <x-button class="bg-indigo-500 hover:bg-indigo-600 shadow-indigo-100 shadow-lg px-6">
            Back
        </x-button>
    </a>
</div>

<div class="space-y-6 pb-20">
    <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
        <form
            action="{{ route('products.update', $product->id) }}"
            method="POST"
            enctype="multipart/form-data"
            x-data="{ 
                productType: '{{ $product->product_type ?? 'single' }}', 
                selectedVariationId: '{{ $product->variation_id ?? '' }}', 
                selectedVariationTypes: @js($product->product_type === 'variation' ? array_keys($product->variations ?? []) : []),
                productVariations: @js($product->variations ?? []),
                variations: @js($variations)
            }"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                {{-- LEFT COLUMN: Main Info --}}
                <div class="lg:col-span-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Name:*</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter Name" required class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                        </div>

                        {{-- SKU/Barcode --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">SKU/Barcode:*</label>
                            <div class="flex">
                                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Enter Code" required class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                            </div>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Product Category:*</label>
                            <div class="flex gap-2">
                                <select name="category_id" required class="flex-1 border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Brand --}}
                        <div>
                            <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Brand:*</label>
                            <div class="flex gap-2">
                                <select name="brand_id" class="flex-1 border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                    <option value="">Choose Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Unit --}}
                        <div>
                            <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Product Unit:*</label>
                            <div class="flex gap-2">
                                <select name="unit_id" required class="flex-1 border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Note:</label>
                            <textarea name="description" rows="5" placeholder="Enter Note" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Images & Stock --}}
                <div class="lg:col-span-4 space-y-8">
                    {{-- Images --}}
                    <div>
                        <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Product Image:</label>
                        <div class="relative group">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="this.nextElementSibling.querySelector('.file-text').innerText = this.files[0].name; if(this.files[0]) { document.getElementById('preview_img').src = URL.createObjectURL(this.files[0]); }">
                            <div class="flex items-center border border-gray-200 rounded-2xl overflow-hidden group-hover:border-indigo-300 transition-all">
                                <div class="bg-gray-100 px-4 py-3.5 text-sm font-bold text-gray-600 border-r border-gray-200">Choose File</div>
                                <div class="px-4 py-3.5 text-sm text-gray-400 file-text truncate">
                                    {{ $product->getFirstMediaUrl('products') ? 'Change Image' : 'No file chosen' }}
                                </div>
                            </div>
                        </div>
                        @if($product->getFirstMediaUrl('products'))
                            <div class="mt-4 text-center">
                                <img id="preview_img" src="{{ $product->getFirstMediaUrl('products') }}" class="w-24 h-24 rounded-2xl object-cover mx-auto border border-gray-100 shadow-sm">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-2">Current Image</p>
                            </div>
                        @endif
                    </div>

                    {{-- Stock Info Card --}}
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 space-y-6">
                        
                        {{-- Warehouse --}}
                        <div>
                            <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Warehouse:*</label>
                            <select name="warehouse_id" class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all bg-white">
                                <option value="">Choose Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ $product->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Supplier --}}
                        <div>
                            <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Supplier:*</label>
                            <select name="supplier_id" class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all bg-white">
                                <option value="">Choose Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status:*</label>
                            <select name="status" class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all bg-white">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-px bg-gray-100 my-10"></div>

            {{-- VARIATION SELECTOR --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Product Type --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Product Type:*</label>
                    <select name="product_type" x-model="productType" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat">
                        <option value="single">Single</option>
                        <option value="variation">Variation</option>
                    </select>
                </div>

                {{-- Variations --}}
                <div x-show="productType === 'variation'" x-transition>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Variations:*</label>
                    <select name="variation_id" x-model="selectedVariationId" @change="selectedVariationTypes = []" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat">
                        <option value="">Select Variation</option>
                        @foreach($variations as $variation)
                            <option value="{{ $variation->id }}">{{ $variation->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Variation Types --}}
                <div x-show="productType === 'variation' && selectedVariationId" x-transition>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Variation Types:*</label>
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        {{-- Select Box / Input Lookalike --}}
                        <div 
                            @click="open = !open"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-2 min-h-[54px] bg-white cursor-pointer flex flex-wrap items-center gap-2 focus-within:ring-4 focus-within:ring-indigo-500/10 focus-within:border-indigo-500 transition-all"
                        >
                            <template x-for="type in selectedVariationTypes" :key="type">
                                <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-[11px] font-black uppercase tracking-wider flex items-center gap-2 border border-gray-200 shadow-sm">
                                    <span x-text="type"></span>
                                    <button type="button" @click.stop="selectedVariationTypes = selectedVariationTypes.filter(t => t !== type)" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </span>
                            </template>
                            <span x-show="selectedVariationTypes.length === 0" class="text-gray-400 text-sm py-2">Select types...</span>
                            
                            {{-- Chevron --}}
                            <div class="ml-auto text-gray-400 pl-2">
                                <svg xmlns="http://www.w3.org/2000/svg" :class="open ? 'rotate-180' : ''" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>

                        {{-- Dropdown Menu --}}
                        <div 
                            x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden py-2"
                        >
                            <template x-for="val in (variations.find(v => v.id == selectedVariationId)?.values || [])" :key="val">
                                <div 
                                    @click="selectedVariationTypes.includes(val) ? selectedVariationTypes = selectedVariationTypes.filter(t => t !== val) : selectedVariationTypes.push(val); open = false"
                                    :class="selectedVariationTypes.includes(val) ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50'"
                                    class="px-5 py-3 text-sm font-bold cursor-pointer transition-colors flex items-center justify-between"
                                >
                                    <span x-text="val"></span>
                                    <template x-if="selectedVariationTypes.includes(val)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                    {{-- Hidden inputs for form submission --}}
                    <template x-for="type in selectedVariationTypes" :key="'hidden_'+type">
                        <input type="hidden" name="variations[]" :value="type">
                    </template>
                </div>
            </div>

            {{-- DYNAMIC VARIATION TABLE --}}
            <div x-show="productType === 'variation' && selectedVariationTypes.length > 0" x-transition class="mt-10 overflow-hidden border border-gray-100 rounded-3xl">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-left border-b border-gray-100">
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Variation Type</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product Cost:*</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product Price:*</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Opening Stock:*</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Stock Alert:*</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">SKU/Barcode:*</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="type in selectedVariationTypes" :key="type">
                            <tr>
                                <td class="p-5">
                                    <div class="bg-indigo-50/50 text-indigo-600 border border-indigo-100 px-4 py-2 rounded-xl font-black text-[11px] uppercase tracking-wider inline-block" x-text="type"></div>
                                </td>
                                <td class="p-5">
                                    <input type="number" step="0.01" :name="'variation_cost['+type+']'" :value="productVariations[type]?.cost || '0.00'" placeholder="0.00" class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-sm font-bold text-gray-700">
                                </td>
                                <td class="p-5">
                                    <input type="number" step="0.01" :name="'variation_price['+type+']'" :value="productVariations[type]?.price || '0.00'" placeholder="0.00" class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-sm font-bold text-gray-700">
                                </td>
                                <td class="p-5">
                                    <input type="number" :name="'variation_opening_stock['+type+']'" :value="productVariations[type]?.opening_stock || '0'" placeholder="0" class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-sm font-bold text-gray-700">
                                </td>
                                <td class="p-5">
                                    <input type="number" :name="'variation_stock_alert['+type+']'" :value="productVariations[type]?.stock_alert || '10'" class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-sm font-bold text-gray-700">
                                </td>
                                <td class="p-5">
                                    <input type="text" :name="'variation_sku['+type+']'" :value="productVariations[type]?.sku || ''" placeholder="Code" class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-sm font-bold text-gray-700">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            {{-- SINGLE PRODUCT FIELDS --}}
            <div x-show="productType === 'single'" x-transition class="mt-10 grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Cost Price:*</label>
                    <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" placeholder="0.00" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                </div>
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Selling Price:*</label>
                    <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" placeholder="0.00" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                </div>
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Opening Stock:*</label>
                    <input type="number" name="opening_stock" value="{{ old('opening_stock', $product->opening_stock) }}" placeholder="0" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                </div>
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Stock Alert:*</label>
                    <input type="number" name="stock_alert" value="{{ old('stock_alert', $product->stock_alert) }}" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-16">
                <button type="submit" class="px-10 py-5 bg-indigo-500 text-white rounded-3xl font-black uppercase tracking-[0.2em] text-xs hover:bg-indigo-600 transition-all shadow-2xl shadow-indigo-200 flex items-center gap-3 active:scale-95 group">
                    <span>Update Product</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </button>
            </div>
        </form>
    </x-card>
</div>

@endsection
