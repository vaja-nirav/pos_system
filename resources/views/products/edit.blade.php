@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Product
            </h1>

            <p class="text-gray-500 text-sm">
                Update product details
            </p>

        </div>

        <a href="{{ route('products.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <x-card x-data="{ productType: '{{ $product->product_type ?? 'single' }}' }">

        <form
            action="{{ route('products.update', $product->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-2 gap-6"
        >

            @csrf
            @method('PUT')

            {{-- Category --}}
            <div>

                <label class="block mb-2 font-medium">
                    Category
                </label>

                <select
                    name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}
                        >

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Brand --}}
            <div>

                <label class="block mb-2 font-medium">
                    Brand
                </label>

                <select
                    name="brand_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    <option value="">
                        Select Brand
                    </option>

                    @foreach($brands as $brand)

                        <option
                            value="{{ $brand->id }}"
                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}
                        >

                            {{ $brand->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Unit --}}
            <div>

                <label class="block mb-2 font-medium">
                    Unit
                </label>

                <select
                    name="unit_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    @foreach($units as $unit)

                        <option
                            value="{{ $unit->id }}"
                            {{ $product->unit_id == $unit->id ? 'selected' : '' }}
                        >

                            {{ $unit->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Supplier --}}
            <div>

                <label class="block mb-2 font-medium">
                    Supplier
                </label>

                <select
                    name="supplier_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    <option value="">
                        Select Supplier
                    </option>

                    @foreach($suppliers as $supplier)

                        <option
                            value="{{ $supplier->id }}"
                            {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}
                        >

                            {{ $supplier->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Product Type --}}
            <div>
                <label class="block mb-2 font-medium">Product Type:*</label>
                <select 
                    name="product_type" 
                    x-model="productType"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                >
                    <option value="single">Single</option>
                    <option value="variation">Variation</option>
                </select>
            </div>

            {{-- Variations (Shown only if product_type is variation) --}}
            <div x-show="productType === 'variation'" x-transition>
                <label class="block mb-2 font-medium">Variations:*</label>
                <select 
                    name="variations[]" 
                    multiple
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none h-[42px]"
                >
                    @php
                        $selectedVariations = $product->variations ?? [];
                    @endphp
                    @foreach($variations as $variation)
                        <option 
                            value="{{ $variation->id }}"
                            {{ in_array($variation->id, $selectedVariations) ? 'selected' : '' }}
                        >
                            {{ $variation->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Product Name --}}
            <div>

                <label class="block mb-2 font-medium">
                    Product Name
                </label>

                <x-input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                />

            </div>

            {{-- SKU --}}
            <div>

                <label class="block mb-2 font-medium">
                    SKU
                </label>

                <x-input
                    type="text"
                    name="sku"
                    value="{{ old('sku', $product->sku) }}"
                />

            </div>

            {{-- Barcode --}}
            <div>

                <label class="block mb-2 font-medium">
                    Barcode
                </label>

                <x-input
                    type="text"
                    name="barcode"
                    value="{{ old('barcode', $product->barcode) }}"
                />

            </div>

            {{-- Cost Price --}}
            <div>

                <label class="block mb-2 font-medium">
                    Cost Price
                </label>

                <x-input
                    type="number"
                    step="0.01"
                    name="cost_price"
                    value="{{ old('cost_price', $product->cost_price) }}"
                />

            </div>

            {{-- Selling Price --}}
            <div>

                <label class="block mb-2 font-medium">
                    Selling Price
                </label>

                <x-input
                    type="number"
                    step="0.01"
                    name="selling_price"
                    value="{{ old('selling_price', $product->selling_price) }}"
                />

            </div>

            {{-- Opening Stock --}}
            <div>

                <label class="block mb-2 font-medium">
                    Opening Stock
                </label>

                <x-input
                    type="number"
                    name="opening_stock"
                    value="{{ old('opening_stock', $product->opening_stock) }}"
                />

            </div>

            {{-- Stock Alert --}}
            <div>

                <label class="block mb-2 font-medium">
                    Stock Alert
                </label>

                <x-input
                    type="number"
                    name="stock_alert"
                    value="{{ old('stock_alert', $product->stock_alert) }}"
                />

            </div>

            {{-- Product Image --}}
            <div>

                <label class="block mb-2 font-medium">
                    Product Image
                </label>

                <x-input
                    type="file"
                    name="image"
                />

            </div>

            {{-- Current Image --}}
             @if($product->getFirstMediaUrl('products'))

                <div>

                    <label class="block mb-2 font-medium">
                        Current Image
                    </label>

                    <img
                        src="{{ $product->getFirstMediaUrl('products') }}"
                        class="w-24 h-24 rounded-lg object-cover"
                        alt="{{ $product->name }}"
                    >

                </div>

            @endif

            {{-- Description --}}
            <div class="col-span-2">

                <label class="block mb-2 font-medium">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >{{ old('description', $product->description) }}</textarea>

            </div>

            {{-- Status --}}
            <div class="col-span-2">

                <label class="block mb-2 font-medium">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    <option
                        value="1"
                        {{ $product->status ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ !$product->status ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>

            <div class="col-span-2">

                <x-button type="submit">
                    Update Product
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection
