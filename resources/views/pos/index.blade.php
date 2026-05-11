@extends('layouts.pos')

@section('content')

<div class="h-full flex gap-3 overflow-hidden">

    {{-- LEFT CART SECTION --}}
    <div class="w-[30%] bg-white rounded-2xl shadow-sm flex flex-col overflow-hidden">

        {{-- TABLE --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar">

            <table class="w-full border-collapse">

                <thead class="sticky top-0 bg-white border-b border-gray-100 z-10">

                    <tr class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">

                        <th class="p-4 text-left">PRODUCT</th>

                        <th class="p-4 text-center">QTY</th>

                        <th class="p-4 text-center">PRICE</th>

                        <th class="p-4 text-right">SUB TOTAL</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-50">

                    <template
                        x-for="(item, index) in cart"
                        :key="index"
                    >

                        <tr>

                            {{-- Product --}}
                            <td class="p-3">

                                <div class="flex flex-col">

                                    <h3
                                        class="font-semibold text-gray-800 text-xs"
                                        x-text="item.name"
                                    ></h3>

                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="text-[10px] text-blue-500 bg-blue-50 px-1.5 py-0.5 rounded font-medium" x-text="item.sku"></span>
                                        <!-- <button class="text-gray-400 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button> -->
                                    </div>

                                </div>

                            </td>

                            {{-- Qty --}}
                            <td class="p-3">

                                <div class="flex items-center justify-center gap-1">

                                    <button
                                        @click="decreaseQty(index)"
                                        class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" /></svg>
                                    </button>

                                    <span
                                        x-text="item.qty"
                                        class="w-6 text-center font-bold text-gray-800 text-xs"
                                    ></span>

                                    <button
                                        @click="increaseQty(index)"
                                        class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                                    </button>

                                </div>

                            </td>

                            {{-- Price --}}
                            <td class="p-3 text-center">

                                <span class="text-xs text-gray-600 font-medium">₹<span x-text="item.price"></span></span>

                            </td>

                            {{-- Subtotal --}}
                            <td class="p-3 text-right">

                                <div class="flex items-center justify-end gap-2">
                                    <span class="text-xs text-gray-800 font-bold">₹<span x-text="(item.price * item.qty).toFixed(2)"></span></span>
                                    <button
                                        @click="removeItem(index)"
                                        class="text-red-400 hover:text-red-600 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>

                            </td>

                        </tr>

                    </template>

                    {{-- Empty --}}
                    <tr x-show="cart.length == 0">

                        <td
                            colspan="4"
                            class="text-center py-20 text-gray-400 text-sm"
                        >
                            No Data Available
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        {{-- BOTTOM --}}
        <div class="border-t border-gray-100 p-4 bg-white space-y-4">

            <div class="space-y-3">
                {{-- Tax --}}
                <div class="relative">
                    <input
                        type="number"
                        x-model="taxPercent"
                        @input="calculateTotals()"
                        placeholder="Tax"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    >
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">%</span>
                </div>

                {{-- Discount --}}
                <!-- <div class="flex items-center gap-6 text-xs text-gray-500">
                    <span class="font-bold">Discount</span>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="discountType" value="fixed" class="text-blue-500 focus:ring-0">
                        <span>Fixed</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="discountType" value="percentage" class="text-blue-500 focus:ring-0">
                        <span>Percentage</span>
                    </label>
                </div> -->

                <div class="grid grid-cols-2 gap-3">
                    <div class="relative">
                        <input
                            type="number"
                            x-model="discount"
                            @input="calculateTotals()"
                            placeholder="Discount"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                    </div>
                    <div class="relative">
                        <input
                            type="number"
                            x-model="shipping"
                            @input="calculateTotals()"
                            placeholder="Shipping"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                    </div>
                </div>
            </div>

            {{-- Totals --}}
            <div class="flex justify-between items-end pt-2">
                <div class="space-y-1 text-xs font-bold text-gray-500">
                    <div class="flex gap-2">
                        <span>Total QTY :</span>
                        <span x-text="totalQty"></span>
                    </div>
                    <div class="flex gap-2 text-blue-500">
                        <span>Sub Total :</span>
                        <span>₹ <span x-text="subtotal.toFixed(2)"></span></span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-green-500 text-xl font-bold">Total : ₹ <span x-text="grandTotal.toFixed(2)"></span></span>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="grid grid-cols-3 gap-3">

                <button
                    class="py-3.5 bg-[#FF6B9B] hover:bg-opacity-90 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95"
                >
                    Hold <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 013 0m-6 8V11a1.5 1.5 0 00-3 0v4.5" /></svg>
                </button>

                <button
                    @click="resetCart()"
                    class="py-3.5 bg-[#F83245] hover:bg-opacity-90 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95"
                >
                    Reset <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </button>

                <button
                    @click="checkoutModal = true"
                    class="py-3.5 bg-[#10B981] hover:bg-opacity-90 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95"
                >
                    Pay Now <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </button>

            </div>

        </div>

    </div>

    {{-- RIGHT PRODUCT SECTION --}}
    <div class="flex-1 flex flex-col gap-3 overflow-hidden">

        {{-- Categories --}}
        <div class="flex flex-wrap gap-2">

            <button
                @click="selectedCategory = 'all'"
                class="px-4 py-2 rounded-lg text-xs font-bold uppercase transition-all"
                :class="
                    selectedCategory == 'all'
                    ? 'bg-[#5D5FEF] text-white shadow-md'
                    : 'bg-white text-gray-500 hover:bg-gray-50 shadow-sm border border-transparent hover:border-gray-100'
                "
            >
                All Categories
            </button>

            @foreach($categories as $category)

                <button
                    @click="selectedCategory = {{ $category->id }}"
                    class="px-4 py-2 rounded-lg text-xs font-bold uppercase transition-all"
                    :class="
                        selectedCategory == {{ $category->id }}
                        ? 'bg-[#5D5FEF] text-white shadow-md'
                        : 'bg-white text-gray-500 hover:bg-gray-50 shadow-sm border border-transparent hover:border-gray-100'
                    "
                >

                    {{ $category->name }}

                </button>

            @endforeach

        </div>

        {{-- Brands --}}
        <div class="flex flex-wrap gap-2">

            <button
                @click="selectedBrand = 'all'"
                class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all"
                :class="
                    selectedBrand == 'all'
                    ? 'bg-[#5D5FEF] text-white shadow-sm'
                    : 'bg-white text-gray-400 shadow-sm border border-transparent hover:border-gray-100'
                "
            >
                All Brands
            </button>

            @foreach($brands as $brand)
                <button
                    @click="selectedBrand = {{ $brand->id }}"
                    class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all"
                    :class="
                        selectedBrand == {{ $brand->id }}
                        ? 'bg-[#5D5FEF] text-white shadow-md'
                        : 'bg-white text-gray-400 shadow-sm border border-transparent hover:border-gray-100'
                    "
                >
                    {{ $brand->name }}
                </button>
            @endforeach

        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-3 overflow-y-auto custom-scrollbar flex-1 pb-4 content-start">

            @foreach($products as $product)

                <div
                    x-show="
                        (
                            selectedCategory == 'all'
                            ||
                            selectedCategory == {{ $product->category_id }}
                        )
                        &&
                        (
                            selectedBrand == 'all'
                            ||
                            selectedBrand == {{ $product->brand_id }}
                        )
                        &&
                        '{{ strtolower($product->name) }}'
                            .includes(search.toLowerCase())
                    "
                    @click='addToCart({
                        id: {{ $product->id }},
                        name: "{{ $product->name }}",
                        sku: "{{ $product->sku }}",
                        unit: "{{ optional($product->unit)->short_name }}",
                        price: {{ $product->selling_price }},
                        stock: {{ $product->current_stock }},
                        image: "{{ $product->getFirstMediaUrl("products") ?: "https://via.placeholder.com/150" }}"
                    })'
                    class="bg-white rounded-xl overflow-hidden cursor-pointer hover:shadow-md transition-shadow group border border-transparent hover:border-blue-100 h-fit"
                >

                    {{-- Image Wrapper --}}
                    <div class="h-28 relative bg-gray-50 flex items-center justify-center overflow-hidden">

                        @if($product->getFirstMediaUrl('products'))

                            <img
                                src="{{ $product->getFirstMediaUrl('products') }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >

                        @else

                            <div class="text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>

                        @endif

                        {{-- Price Bubble --}}
                        <div class="absolute top-1.5 left-1.5 bg-[#5D5FEF] text-white text-[9px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                            ₹ {{ $product->selling_price }}
                        </div>
                        
                        {{-- Stock Bubble --}}
                        <div class="absolute top-1.5 right-1.5 bg-blue-400 text-white text-[9px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                            {{ optional($product->unit)->short_name }}
                        </div>

                    </div>

                    {{-- Content --}}
                    <div class="p-2">

                        <h3 class="font-bold text-gray-800 text-[11px] truncate leading-tight">
                            {{ $product->name }}
                        </h3>

                        <p class="text-[9px] text-gray-400 mt-0.5 uppercase tracking-tighter font-medium">
                            {{ $product->sku }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    </div>

    {{-- CHECKOUT MODAL --}}
    <div
        x-show="checkoutModal"
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
        style="display:none;"
    >
        <div
            @click.away="checkoutModal = false"
            class="bg-white rounded-2xl shadow-xl w-full max-w-5xl overflow-hidden flex flex-col max-h-[90vh]"
        >
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
                <h2 class="text-xl font-bold text-gray-800">Make Payment</h2>
                <button @click="checkoutModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" /></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Left Side: Form --}}
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Amount:</label>
                                <input type="number" x-model="paidAmount" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none">
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Payment Type:<span class="text-red-500">*</span></label>
                                <div class="flex gap-2">
                                    <select x-model="paymentType" class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none">
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Online">Online</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Note:</label>
                            <textarea x-model="note" rows="4" placeholder="Enter Note" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none"></textarea>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Payment Status:<span class="text-red-500">*</span></label>
                            <select x-model="paymentStatus" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none">
                                <option value="paid">Paid</option>
                                <option value="partial">Partial</option>
                                <option value="due">Due</option>
                            </select>
                        </div>
                    </div>

                    {{-- Right Side: Summary --}}
                    <div class="bg-gray-50/50 rounded-2xl border border-gray-100 p-6">
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-gray-100">
                                <tr class="group">
                                    <td class="py-3 text-gray-500">Total Products</td>
                                    <td class="py-3 text-right font-bold text-indigo-600">
                                        <span class="bg-indigo-50 px-3 py-1 rounded-lg" x-text="parseFloat(totalQty).toFixed(1)"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-gray-500">Total Amount</td>
                                    <td class="py-3 text-right font-semibold" x-text="'₹ ' + parseFloat(subtotal).toFixed(1)"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-gray-500">Order Tax</td>
                                    <td class="py-3 text-right font-semibold text-gray-700" x-text="'₹ ' + parseFloat(tax).toFixed(1) + ' (' + (taxPercent || 0) + '.00 %)'"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-gray-500">Discount</td>
                                    <td class="py-3 text-right font-semibold text-gray-700" x-text="'₹ ' + parseFloat(discount || 0).toFixed(1)"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-gray-500">Shipping</td>
                                    <td class="py-3 text-right font-semibold text-gray-700" x-text="'₹ ' + parseFloat(shipping || 0).toFixed(1)"></td>
                                </tr>
                                <tr class="border-t-2 border-gray-200">
                                    <td class="py-4 text-gray-800 font-bold">Grand Total</td>
                                    <td class="py-4 text-right font-black text-lg text-gray-900" x-text="'₹ ' + parseFloat(grandTotal).toFixed(1)"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-gray-500">Change Return</td>
                                    <td class="py-3 text-right font-semibold text-green-600" x-text="'₹ ' + Math.max(0, parseFloat(paidAmount || 0) - grandTotal).toFixed(1)"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-white">
                <button @click="submitSale(false)" class="px-6 py-2.5 bg-indigo-500 text-white rounded-xl font-semibold hover:bg-indigo-600 transition-colors">Submit</button>
                <button @click="submitSale(true)" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors">Submit & Print</button>
                <button @click="checkoutModal = false" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-colors">Cancel</button>
            </div>
        </div>
    </div>

    {{-- INVOICE/RECEIPT MODAL --}}
    <div
        x-show="invoiceModal"
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-[60] p-4"
        style="display:none;"
    >
        <div
            @click.away="invoiceModal = false"
            class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden flex flex-col"
        >
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">Invoice POS</h2>
                <button @click="invoiceModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" /></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]" id="receipt-content">
                <div class="text-center mb-6">
                    <div class="flex justify-center mb-2">
                        <svg class="h-12 w-12 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <h3 class="text-xl font-black uppercase tracking-widest">General Store</h3>
                    <p class="text-[10px] text-gray-500 mt-1">GST: 29ABCDE1234F1Z5</p>
                    <p class="text-[10px] text-gray-500">FSSAI: 1212HBHJBH664A</p>
                </div>

                <div class="space-y-1 text-[11px] text-gray-600 border-b border-dashed border-gray-200 pb-4 mb-4">
                    <div class="flex justify-between">
                        <span>Date:</span>
                        <span class="font-bold" x-text="new Date().toLocaleString()"></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span>Address:</span>
                        <span class="text-right max-w-[150px]"> Surat, Gujarat.</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Email:</span>
                        <span>exampal@gmail.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Phone:</span>
                        <span>1234567890</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Customer:</span>
                        <span class="font-bold" x-text="customer ? 'ID: ' + customer : 'Nirav vaja'"></span>
                    </div>
                </div>

                <table class="w-full text-[11px] mb-4">
                    <thead>
                        <tr class="border-b border-dashed border-gray-200 text-left">
                            <th class="py-2">Item</th>
                            <th class="py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dashed divide-gray-100">
                        <template x-for="item in cart" :key="item.id">
                            <tr>
                                <td class="py-2">
                                    <div class="font-bold" x-text="item.name + ' (' + item.sku + ')'"></div>
                                    <div class="text-[10px] text-gray-500" x-text="'Price: ₹ ' + item.price"></div>
                                    <div x-text="item.qty + ' X ₹ ' + item.price"></div>
                                </td>
                                <td class="py-2 text-right font-bold" x-text="'₹ ' + (item.qty * item.price).toFixed(1)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <div class="space-y-1 text-[11px] border-t border-dashed border-gray-200 pt-4">
                    <div class="flex justify-between">
                        <span>Total Amount:</span>
                        <span class="font-bold" x-text="'₹ ' + parseFloat(subtotal).toFixed(1)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span x-text="'Order Tax: (' + (taxPercent || 0) + '.00 %)'"></span>
                        <span class="font-bold" x-text="'₹ ' + parseFloat(tax).toFixed(1)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount:</span>
                        <span class="font-bold" x-text="'₹ ' + parseFloat(discount || 0).toFixed(1)"></span>
                    </div>
                    <div class="flex justify-between text-base font-black border-y border-dashed border-gray-200 py-2 my-2">
                        <span>Grand Total:</span>
                        <span x-text="'₹ ' + parseFloat(grandTotal).toFixed(1)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Paid Amount:</span>
                        <span class="font-bold" x-text="'₹ ' + parseFloat(paidAmount || 0).toFixed(1)"></span>
                    </div>
                    <div class="flex justify-between text-green-600 font-bold">
                        <span>Change Return:</span>
                        <span x-text="'₹ ' + Math.max(0, parseFloat(paidAmount || 0) - grandTotal).toFixed(1)"></span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex gap-3 bg-white">
                <button @click="printReceipt()" class="flex-1 py-2.5 bg-indigo-500 text-white rounded-xl font-bold hover:bg-indigo-600 transition-colors">Print</button>
                <button @click="invoiceModal = false; resetCart();" class="flex-1 py-2.5 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-colors">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection