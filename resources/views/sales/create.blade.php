@extends('layouts.app')

@section('content')

<div
    x-data="saleHandler()"
    class="max-w-7xl mx-auto"
>

<div
    x-data="saleHandler()"
    class="max-w-7xl mx-auto"
>

    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">
                Create Sale
            </h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">Generate a new invoice for your customer</p>
        </div>

        <a href="{{ route('sales.index') }}">
            <x-button class="border border-gray-200 px-6 rounded-2xl font-bold">
                Back
            </x-button>
        </a>

    </div>

    <form
        action="{{ route('sales.store') }}"
        method="POST"
        class="space-y-8"
    >

        @csrf

        {{-- Top Section --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Customer --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Customer:*
                    </label>

                    <select
                        name="customer_id"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat font-bold text-gray-700"
                    >

                        <option value="">
                            Walk-in Customer
                        </option>

                        @foreach($customers as $customer)

                            <option value="{{ $customer->id }}">

                                {{ $customer->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Sale Date --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Sale Date:*
                    </label>

                    <input
                        type="date"
                        name="sale_date"
                        value="{{ date('Y-m-d') }}"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700"
                    >

                </div>

                {{-- Payment Status --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Payment Status:*
                    </label>
                    <select
                        name="payment_status"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat font-bold text-gray-700"
                    >
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="due">Due</option>
                    </select>
                </div>

                {{-- Payment Type --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Payment Type:*
                    </label>
                    <select
                        name="payment_type"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat font-bold text-gray-700"
                    >
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Card">Card</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

        </x-card>

        {{-- Product Table --}}
        <x-card class="mt-8 border-none shadow-xl shadow-gray-100 rounded-3xl p-8 !overflow-visible">

            <div class="overflow-visible">

                <table class="w-full">

                    <thead class="bg-gray-50/50">

                        <tr class="text-left border-b border-gray-100">

                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Product
                            </th>

                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">
                                Stock
                            </th>

                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Qty
                            </th>

                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Price
                            </th>

                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                Total
                            </th>

                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-50">

                        <template x-for="(item, index) in products">

                            <tr>

                                {{-- Product --}}
                                <td class="p-5 min-w-[280px]">
                                    <div class="space-y-1">
                                        <select
                                            :name="'product_id[' + index + ']'"
                                            x-model="item.product_id"
                                            @change="setPrice(index)"
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat font-bold text-gray-700"
                                        >
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option
                                                    value="{{ $product->id }}"
                                                    data-price="{{ $product->selling_price }}"
                                                    data-stock="{{ $product->current_stock }}"
                                                    data-type="{{ $product->product_type }}"
                                                    data-variations='@json($product->variations)'
                                                >
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- Professional Variation Searchable Dropdown --}}
                                        <template x-if="item.product_type === 'variation'">
                                            <div class="pt-3 relative" x-data="{ open: false, search: '' }" :class="open ? 'z-[9999]' : ''">
                                                <button 
                                                    type="button"
                                                    @click="open = !open"
                                                    class="w-full flex items-center justify-between border border-indigo-100 bg-indigo-50/30 rounded-xl px-4 py-2.5 text-sm transition-all hover:border-indigo-300"
                                                    :class="open ? 'ring-2 ring-indigo-500/20 border-indigo-500' : ''"
                                                >
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-black text-[10px] uppercase tracking-wider text-indigo-600" x-text="item.variation_name || 'Choose Variant'"></span>
                                                        <template x-if="item.variation_name">
                                                            <span class="bg-indigo-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md uppercase tracking-tighter shadow-sm shadow-indigo-200">Selected</span>
                                                        </template>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                                </button>

                                                {{-- Dropdown Menu with ultra-high z-index --}}
                                                <div 
                                                    x-show="open" 
                                                    @click.away="open = false"
                                                    class="absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] z-[9999] overflow-hidden min-w-[220px]"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                >
                                                    <div class="p-3 border-b border-gray-50 bg-gray-50/30">
                                                        <input 
                                                            type="text" 
                                                            x-model="search" 
                                                            placeholder="Search variants..." 
                                                            class="w-full px-4 py-2 text-xs border border-gray-200 rounded-xl bg-white outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                                        >
                                                    </div>
                                                    <div class="max-h-60 overflow-y-auto py-1">
                                                        <template x-for="(vData, vName) in item.all_variations || {}" :key="vName">
                                                            <button 
                                                                type="button"
                                                                x-show="!search || vName.toLowerCase().includes(search.toLowerCase())"
                                                                @click="addVariant(index, vName); open = false"
                                                                class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-indigo-50/50 transition-colors group"
                                                            >
                                                                <div class="flex flex-col">
                                                                    <span class="text-xs font-bold text-gray-700 group-hover:text-indigo-600" x-text="vName"></span>
                                                                </div>
                                                                <div class="flex items-center gap-3">
                                                                    <span class="text-[10px] font-black text-indigo-500 bg-indigo-50 px-2 py-1 rounded-lg" x-text="'₹' + (vData.price || 0)"></span>
                                                                    <div x-show="item.variation_name === vName" class="text-indigo-600">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </template>
                                                        <div x-show="Object.keys(item.all_variations || {}).length === 0" class="p-4 text-center text-gray-400 text-[10px] uppercase font-bold tracking-widest">
                                                            No Variants Found
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" :name="'variation_name[' + index + ']'" x-model="item.variation_name">
                                            </div>
                                        </template>
                                    </div>
                                </td>

                                {{-- Stock --}}
                                <td class="p-5 text-center">
                                    <span
                                        class="inline-block px-4 py-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl text-xs font-black shadow-sm"
                                        x-text="item.stock"
                                    ></span>
                                </td>

                                {{-- Qty --}}
                                <td class="p-5">
                                    <input
                                        type="number"
                                        min="1"
                                        x-model="item.quantity"
                                        @input="calculate(index)"
                                        :name="'quantity[' + index + ']'"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700"
                                    >
                                </td>

                                {{-- Price --}}
                                <td class="p-5">
                                    <input
                                        type="number"
                                        step="0.01"
                                        x-model="item.price"
                                        @input="calculate(index)"
                                        :name="'price[' + index + ']'"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700"
                                    >
                                </td>

                                {{-- Total --}}
                                <td class="p-5">
                                    <input
                                        type="number"
                                        step="0.01"
                                        x-model="item.total"
                                        :name="'subtotal_item[' + index + ']'"
                                        readonly
                                        class="w-full border border-gray-100 bg-gray-50/50 rounded-2xl px-5 py-3.5 outline-none font-bold text-gray-800"
                                    >
                                </td>

                                {{-- Remove --}}
                                <td class="p-5 text-center">
                                    <button
                                        type="button"
                                        @click="removeRow(index)"
                                        class="p-3.5 bg-red-50 text-red-500 border border-red-100 rounded-2xl hover:bg-red-500 hover:text-white transition-all group shadow-sm"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </td>

                            </tr>

                        </template>

                    </tbody>

                </table>

            </div>

            <button
                type="button"
                @click="addRow()"
                class="mt-8 px-6 py-4 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-600 hover:text-white transition-all shadow-sm flex items-center gap-3 group"
            >
                <div class="w-6 h-6 rounded-full bg-white flex items-center justify-center text-indigo-600 shadow-sm group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                </div>
                <span>Add New Product</span>
            </button>

        </x-card>

        {{-- Totals --}}
        <x-card class="mt-8 border-none shadow-xl shadow-gray-100 rounded-3xl p-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- Subtotal --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Subtotal
                    </label>

                    <input
                        type="number"
                        x-model="subtotal"
                        name="subtotal"
                        readonly
                        class="w-full border border-gray-100 bg-gray-50/50 rounded-2xl px-5 py-3.5 outline-none font-black text-gray-800"
                    >

                </div>

                {{-- Discount --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Discount
                    </label>

                    <input
                        type="number"
                        x-model="discount"
                        @input="calculateTotals()"
                        name="discount"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700"
                    >

                </div>

                {{-- Tax --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Tax
                    </label>

                    <input
                        type="number"
                        x-model="tax"
                        @input="calculateTotals()"
                        name="tax"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700"
                    >

                </div>

                {{-- Total --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-indigo-600 uppercase tracking-widest">
                        Grand Total
                    </label>

                    <input
                        type="number"
                        x-model="grandTotal"
                        name="total"
                        readonly
                        class="w-full border border-indigo-100 bg-indigo-50/30 rounded-2xl px-5 py-3.5 outline-none font-black text-indigo-700 shadow-sm"
                    >

                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10 pt-10 border-t border-gray-50">

                {{-- Paid --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Paid Amount:*
                    </label>

                    <input
                        type="number"
                        x-model="paidAmount"
                        @input="calculateDue()"
                        name="paid_amount"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-indigo-600 bg-indigo-50/10"
                    >

                </div>

                {{-- Due --}}
                <div>

                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Due Amount
                    </label>

                    <input
                        type="number"
                        x-model="dueAmount"
                        name="due_amount"
                        readonly
                        class="w-full border border-red-50 bg-red-50/30 rounded-2xl px-5 py-3.5 outline-none font-black text-red-600"
                    >

                </div>

            </div>

            {{-- Note --}}
            <div class="mt-8">

                <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                    Sale Note:
                </label>

                <textarea
                    name="note"
                    rows="4"
                    placeholder="Enter special instructions or notes..."
                    class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300 font-medium"
                ></textarea>

            </div>

            {{-- Submit --}}
            <div class="flex justify-end mt-12">

                <button type="submit" class="px-12 py-5 bg-indigo-500 text-white rounded-3xl font-black uppercase tracking-[0.2em] text-xs hover:bg-indigo-600 transition-all shadow-2xl shadow-indigo-200 flex items-center gap-4 active:scale-95 group">
                    <span>Complete Sale</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </button>

            </div>

        </x-card>

    </form>

</div>

<script>

function saleHandler()
{
    return {

        products: [
            {
                product_id: '',
                product_type: 'single',
                variation_name: '',
                all_variations: {},
                quantity: 1,
                price: 0,
                total: 0,
                stock: 0
            }
        ],

        subtotal: 0,
        discount: 0,
        tax: 0,
        grandTotal: 0,
        paidAmount: 0,
        dueAmount: 0,

        addRow()
        {
            this.products.push({
                product_id: '',
                product_type: 'single',
                variation_name: '',
                all_variations: {},
                quantity: 1,
                price: 0,
                total: 0,
                stock: 0
            });
        },

        removeRow(index)
        {
            this.products.splice(index, 1);

            this.calculateTotals();
        },

        setPrice(index)
        {
            let select = document.querySelectorAll('select[name^="product_id"]')[index];

            if(!select) return;

            let option = select.options[select.selectedIndex];
            let item = this.products[index];
            let productId = option.value;

            if (!productId) return;

            // Check if this single product already exists in another row
            let productType = option.dataset.type || 'single';
            if (productType === 'single') {
                let existingItem = this.products.find((p, i) => 
                    p.product_id === productId && 
                    i !== index && 
                    p.product_type === 'single'
                );

                if (existingItem) {
                    // Increase quantity of existing row
                    existingItem.quantity = Number(existingItem.quantity) + 1;
                    this.calculate(this.products.indexOf(existingItem));
                    
                    // Remove the current duplicate row
                    this.removeRow(index);
                    return;
                }
            }

            item.product_type = productType;
            item.all_variations = JSON.parse(option.dataset.variations || '{}');
            
            if (item.product_type === 'variation') {
                item.price = 0;
                item.stock = 0;
                item.variation_name = '';
            } else {
                item.price = option.dataset.price || 0;
                item.stock = option.dataset.stock || 0;
            }

            this.calculate(index);
        },

        setVariationPrice(index)
        {
            let item = this.products[index];
            if (item.variation_name && item.all_variations[item.variation_name]) {
                let v = item.all_variations[item.variation_name];
                item.price = v.price || 0;
                item.stock = v.opening_stock || 0;
            } else {
                item.price = 0;
                item.stock = 0;
            }
            this.calculate(index);
        },

        addVariant(index, vName)
        {
            let currentItem = this.products[index];
            let vData = currentItem.all_variations[vName];

            // Check if this exact product + variant combination already exists in any row
            let existingItem = this.products.find(p => 
                p.product_id === currentItem.product_id && 
                p.variation_name === vName
            );

            if (existingItem) {
                // If it already exists, just increase its quantity
                existingItem.quantity = Number(existingItem.quantity) + 1;
                this.calculate(this.products.indexOf(existingItem));
                
                // If the current row we clicked from was just an empty selector, remove it if it's not the existing one
                if (!currentItem.variation_name && currentItem !== existingItem) {
                    this.removeRow(index);
                }
                return;
            }

            // If current row is an empty selector (product chosen but no variant yet)
            if (!currentItem.variation_name) {
                currentItem.variation_name = vName;
                currentItem.price = vData.price || 0;
                currentItem.stock = vData.opening_stock || 0;
                this.calculate(index);
            } else {
                // Add as a new row
                this.products.splice(index + 1, 0, {
                    product_id: currentItem.product_id,
                    product_type: 'variation',
                    variation_name: vName,
                    all_variations: currentItem.all_variations,
                    quantity: 1,
                    price: vData.price || 0,
                    stock: vData.opening_stock || 0,
                    total: vData.price || 0
                });
                this.calculateTotals();
            }
        },

        calculate(index)
        {
            let item = this.products[index];

            // Stock Check
            if (Number(item.quantity) > Number(item.stock)) {
                toastr.warning('Only ' + item.stock + ' items available in stock!');
                item.quantity = item.stock;
            }

            item.total =
                item.quantity * item.price;

            this.calculateTotals();
        },

        calculateTotals()
        {
            this.subtotal = this.products.reduce(
                (sum, item) => sum + Number(item.total),
                0
            );

            this.grandTotal =
                Number(this.subtotal)
                - Number(this.discount)
                + Number(this.tax);

            this.calculateDue();
        },

        calculateDue()
        {
            this.dueAmount =
                Number(this.grandTotal)
                - Number(this.paidAmount);
        }
    }
}

</script>

@endsection