@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Add Product
            </h1>

            <p class="text-gray-500 text-sm">
                Create new product
            </p>

        </div>

        <a href="{{ route('products.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <x-card x-data="{ productType: 'single' }">

        <form
            action="{{ route('products.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-2 gap-6"
        >

            @csrf

            {{-- Category --}}
            <div>

                <label class="block mb-2 font-medium">
                    Category
                </label>

                <select
                    name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    <option value="">
                        Select Category
                    </option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}">

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

                        <option value="{{ $brand->id }}">

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

                    <option value="">
                        Select Unit
                    </option>

                    @foreach($units as $unit)

                        <option value="{{ $unit->id }}">

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

                        <option value="{{ $supplier->id }}">

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
                    @foreach($variations as $variation)
                        <option value="{{ $variation->id }}">{{ $variation->name }}</option>
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
                    placeholder="Enter product name"
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
                    placeholder="Enter SKU"
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
                    placeholder="Enter barcode"
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
                    placeholder="Enter cost price"
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
                    placeholder="Enter selling price"
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
                    value="0"
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
                    value="5"
                />

            </div>

            {{-- Product Image --}}
            <div>

                <label class="block mb-2 font-medium">
                    Product Image
                </label>

                <x-input
                    type="file"
                    name="images[]"
                    multiple
                />

            </div>

            {{-- Description --}}
            <div class="col-span-2">

                <label class="block mb-2 font-medium">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                ></textarea>

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

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>

                </select>

            </div>

            <div class="col-span-2">

                <x-button type="submit">
                    Save Product
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection