@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Products
        </h1>

        <p class="text-gray-500 text-sm">
            Manage all products
        </p>

    </div>

    <a href="{{ route('products.create') }}">

        <x-button>
            + Add Product
        </x-button>

    </a>

</div>

<x-card>

    <x-table>

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Image
                </th>

                <th class="p-4 text-left">
                    Product
                </th>

                <th class="p-4 text-left">
                    Category
                </th>

                <th class="p-4 text-left">
                    Supplier
                </th>

                <th class="p-4 text-left">
                    Brand
                </th>

                <th class="p-4 text-left">
                    Unit
                </th>

                <th class="p-4 text-left">
                    Price
                </th>

                <th class="p-4 text-left">
                    Status
                </th>

                <th class="p-4 text-center w-24">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $product)

                <tr class="border-t">

                    {{-- Image --}}
                    <td class="p-4">

                        @php $imgUrl = $product->getFirstMediaUrl('products'); @endphp

                        @if($imgUrl)
                            <img
                                src="{{ $imgUrl }}"
                                class="w-12 h-12 rounded-lg object-cover"
                                alt="{{ $product->name }}"
                                style="border:1px solid #e5e7eb;"
                                onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';"
                            >
                            <div style="display:none;width:48px;height:48px;border-radius:8px;background:#f3f4f6;border:1px solid #e5e7eb;align-items:center;justify-content:center;">
                                <svg style="width:20px;height:20px;color:#9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @else
                            <div style="width:48px;height:48px;border-radius:8px;background:#f3f4f6;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;">
                                <svg style="width:20px;height:20px;color:#9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                    </td>

                    {{-- Product --}}
                    <td class="p-4">

                        <div class="font-semibold text-gray-800">
                            {{ $product->name }}
                        </div>

                        <div class="text-sm text-gray-500">
                            SKU: {{ $product->sku }}
                        </div>

                    </td>

                    {{-- Category --}}
                    <td class="p-4">
                        {{ $product->category->name }}
                    </td>

                    {{-- Supplier --}}
                    <td class="p-4">
                        {{ $product->supplier?->name ?? '-' }}
                    </td>

                    {{-- Brand --}}
                    <td class="p-4">

                        {{ $product->brand?->name ?? '-' }}

                    </td>

                    {{-- Unit --}}
                    <td class="p-4">
                        {{ $product->unit->short_name }}
                    </td>

                    {{-- Price --}}
                    <td class="p-4">

                        <div>
                            ₹{{ number_format($product->selling_price, 2) }}
                        </div>

                        <div class="text-sm text-gray-500">
                            Cost: ₹{{ number_format($product->cost_price, 2) }}
                        </div>

                    </td>

                    {{-- Status --}}
                    <td class="p-4">

                        @if($product->status)

                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">
                                Active
                            </span>

                        @else

                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm">
                                Inactive
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
                                <a
                                    href="{{ route('products.edit', $product->id) }}"
                                    class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition"
                                >
                                    <span class="font-medium text-gray-700">
                                        Edit Product
                                    </span>
                                </a>

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

                    <td colspan="8" class="p-6 text-center text-gray-500">
                        No Products Found
                    </td>

                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">
        {{ $products->links() }}
    </div>

</x-card>

    <!-- Barcode Modal (Iframe) -->
    <div x-data="{ showBarcodeModal: false, barcodeSrc: '' }" 
         @open-barcode.window="barcodeSrc = $event.detail; showBarcodeModal = true">
        <div
            x-show="showBarcodeModal"
            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
            style="display: none;"
        >
            <div
                @click.away="showBarcodeModal = false; barcodeSrc = ''"
                class="bg-white rounded-2xl shadow-xl w-full max-w-sm relative overflow-hidden"
            >
                <!-- Close Button -->
                <button
                    @click="showBarcodeModal = false; barcodeSrc = ''"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 bg-gray-100 rounded-full p-1 z-10"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <iframe :src="barcodeSrc" class="w-full h-[450px] border-0" title="Product Barcode"></iframe>
            </div>
        </div>
    </div>

@endsection