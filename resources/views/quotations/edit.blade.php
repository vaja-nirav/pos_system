@extends('layouts.app')

@section('content')

<div x-data="quotationHandler()" class="max-w-7xl mx-auto pb-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 uppercase tracking-tight">
                Edit Quotation
            </h1>
            <p class="text-gray-500 text-xs mt-1 font-medium italic">Reference: <span class="text-indigo-600 font-bold">#{{ $quotation->quotation_no }}</span></p>
        </div>

        <a href="{{ route('quotations.index') }}">
            <button class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-gray-50 transition-all shadow-sm">
                Back to List
            </button>
        </a>
    </div>

    <form action="{{ route('quotations.update', $quotation->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Basic Information --}}
        <x-card class="border border-gray-100 shadow-sm rounded-2xl p-6 bg-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Customer --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider ml-1">
                        Customer Selection:*
                    </label>
                    <div class="relative group">
                        <select
                            name="customer_id"
                            required
                            class="w-full border border-gray-200 bg-gray-50/30 rounded-xl px-5 py-3 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none font-semibold text-gray-700 text-sm"
                        >
                            <option value="">Walk-in Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $quotation->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Quotation Date --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider ml-1">
                        Quotation Date:*
                    </label>
                    <input
                        type="date"
                        name="quotation_date"
                        required
                        value="{{ $quotation->quotation_date }}"
                        class="w-full border border-gray-200 bg-gray-50/30 rounded-xl px-5 py-3 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-semibold text-gray-700 text-sm"
                    >
                </div>
            </div>
        </x-card>

        {{-- Itemized List --}}
        <x-card class="border border-gray-100 shadow-sm rounded-2xl p-0 !overflow-visible bg-white">
            <div class="p-6 pb-4 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight mb-1">Itemized Estimate</h3>
                    <p class="text-gray-400 text-[10px] font-medium">Modify products and variations for this quotation</p>
                </div>
                <div class="bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100">
                    <span class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest mr-2">Status:</span>
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">{{ $quotation->status }}</span>
                </div>
            </div>
            
            <div class="overflow-x-auto md:overflow-visible custom-scrollbar">
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr class="text-left border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">In Stock</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Qty</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Unit Price</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Line Total</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="(item, index) in products" :key="index">
                            <tr class="group hover:bg-gray-50/50 transition-all">
                                <td class="px-6 py-3 min-w-[300px]">
                                    <div class="space-y-2">
                                        <div class="relative">
                                            <select
                                                :name="'product_id[' + index + ']'"
                                                x-model="item.product_id"
                                                @change="setPrice(index)"
                                                class="w-full border border-gray-200 bg-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none font-semibold text-gray-700 text-sm shadow-sm"
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
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                            </div>
                                        </div>

                                        <template x-if="item.product_type === 'variation'">
                                            <div class="relative" x-data="{ open: false, search: '' }">
                                                <button 
                                                    type="button"
                                                    @click="open = !open"
                                                    class="w-full flex items-center justify-between border border-indigo-100 bg-indigo-50/40 rounded-xl px-4 py-3 text-xs transition-all hover:bg-indigo-100/50"
                                                    :class="open ? 'ring-2 ring-indigo-500/10 border-indigo-400 bg-white shadow-sm' : ''"
                                                >
                                                    <span class="font-bold uppercase tracking-widest text-indigo-600 text-[10px]" x-text="item.variation_name || 'Select Variant'"></span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                                </button>

                                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-xl shadow-2xl z-[999] overflow-hidden" style="display: none;">
                                                    <div class="max-h-40 overflow-y-auto custom-scrollbar">
                                                        <template x-for="(vData, vName) in item.all_variations || {}">
                                                            <button type="button" @click="addVariant(index, vName); open = false" class="w-full px-4 py-2.5 text-left hover:bg-indigo-50 transition-colors flex justify-between items-center group">
                                                                <span class="text-[10px] font-bold text-gray-600 group-hover:text-indigo-600" x-text="vName"></span>
                                                                <span class="text-[10px] font-bold text-indigo-500" x-text="'₹' + (vData.price || 0)"></span>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                                <input type="hidden" :name="'variation_name[' + index + ']'" x-model="item.variation_name">
                                            </div>
                                        </template>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-wider border border-blue-100" x-text="item.stock"></span>
                                </td>

                                <td class="px-4 py-3 w-24">
                                    <input type="number" min="1" x-model="item.quantity" @input="calculate(index)" :name="'quantity[' + index + ']'" class="w-full border border-gray-200 bg-white rounded-xl px-3 py-2 text-center focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700 text-sm shadow-sm">
                                </td>

                                <td class="px-4 py-3 w-36">
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs">₹</span>
                                        <input type="number" step="0.01" x-model="item.price" @input="calculate(index)" :name="'price[' + index + ']'" class="w-full border border-gray-200 bg-white rounded-xl pl-6 pr-3 py-2 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700 text-sm shadow-sm">
                                    </div>
                                </td>

                                <td class="px-4 py-3 w-36 text-xs font-bold text-gray-700 text-center py-2" x-text="formatCurrency(item.total)"></td>
                                <input type="hidden" :name="'subtotal_item[' + index + ']'" x-model="item.total">

                                <td class="px-6 py-3 text-center">
                                    <button type="button" @click="removeRow(index)" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all border border-red-100 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-gray-50/50 rounded-b-2xl border-t border-gray-100">
                <button type="button" @click="addRow()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    <span>Add Item</span>
                </button>
            </div>
        </x-card>

        {{-- Totals and Notes --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            <div class="lg:col-span-2 h-full">
                <x-card class="border border-gray-100 shadow-sm rounded-2xl p-6 h-full bg-white">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider ml-1 mb-3">Quotation Notes:</label>
                    <textarea name="note" rows="6" class="w-full border border-gray-200 bg-gray-50/20 rounded-xl px-5 py-4 outline-none font-medium text-gray-700 shadow-inner text-xs leading-relaxed">{{ $quotation->note }}</textarea>
                </x-card>
            </div>

            <div>
                <x-card class="border border-gray-100 shadow-sm rounded-2xl p-6 space-y-5 bg-white">
                    <div class="flex justify-between items-center px-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Subtotal</span>
                        <span class="font-bold text-gray-800 text-sm" x-text="formatCurrency(subtotal)"></span>
                        <input type="hidden" name="subtotal" x-model="subtotal">
                    </div>

                    <div class="space-y-1.5 px-2">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider ml-1">Discount</label>
                        <input type="number" x-model="discount" @input="calculateTotals()" name="discount" class="w-full border border-gray-200 bg-gray-50/20 rounded-xl px-4 py-2.5 outline-none font-bold text-gray-700 text-sm focus:border-indigo-400 transition-all">
                    </div>

                    <div class="space-y-1.5 px-2 pb-5 border-b border-gray-50">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider ml-1">Tax (%)</label>
                        <div class="relative group">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 font-bold group-focus-within:text-indigo-400 transition-colors text-xs">%</span>
                            <input type="number" x-model="tax_percent" max="100" @input="calculateTotals()" name="tax_percent" class="w-full border border-gray-200 bg-gray-50/20 rounded-xl px-4 py-2.5 outline-none font-bold text-gray-700 text-sm focus:border-indigo-400 transition-all shadow-inner">
                        </div>
                    </div>

                    <div class="flex justify-between items-center px-5 py-4 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-100">
                        <span class="text-[10px] font-bold text-indigo-100 uppercase tracking-wider">Total</span>
                        <span class="text-xl font-black text-white tracking-tight" x-text="formatCurrency(grandTotal)"></span>
                        <input type="hidden" name="total" x-model="grandTotal">
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-xl font-bold uppercase tracking-wider text-[10px] hover:bg-indigo-700 transition-all shadow-md active:scale-95 mt-4">Update Quotation</button>
                </x-card>
            </div>
        </div>
    </form>
</div>

<script>
function quotationHandler() {
    return {
        products: {!! json_encode($quotation->items->map(fn($item) => [
            'product_id' => $item->product_id,
            'product_type' => $item->product->product_type ?? 'single',
            'variation_name' => $item->variation,
            'all_variations' => $item->product->variations ?? [],
            'quantity' => $item->quantity,
            'price' => $item->price,
            'total' => $item->subtotal,
            'stock' => $item->product->current_stock ?? 0
        ])) !!},
        subtotal: {{ $quotation->subtotal }},
        discount: {{ $quotation->discount }},
        tax_percent: {{ $quotation->tax_percent }},
        tax: {{ $quotation->tax }},
        grandTotal: {{ $quotation->total }},

        formatCurrency(value) {
            return '₹' + Number(value || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        },

        addRow() {
            this.products.push({ product_id: '', product_type: 'single', variation_name: '', all_variations: {}, quantity: 1, price: 0, total: 0, stock: 0 });
        },
        removeRow(index) {
            this.products.splice(index, 1);
            this.calculateTotals();
        },
        setPrice(index) {
            let select = document.querySelectorAll('select[name^="product_id"]')[index];
            if(!select) return;
            let option = select.options[select.selectedIndex];
            let item = this.products[index];
            if (!option.value) return;
            item.product_type = option.dataset.type || 'single';
            item.all_variations = JSON.parse(option.dataset.variations || '{}');
            if (item.product_type === 'variation') { item.price = 0; item.stock = 0; item.variation_name = ''; } 
            else { 
                item.price = option.dataset.price || 0; 
                item.stock = option.dataset.stock || 0; 

                // Check for duplicates (Single Products)
                let existingIndex = this.products.findIndex((p, idx) => 
                    idx !== index && 
                    p.product_id == item.product_id && 
                    !p.variation_name
                );
                
                if (existingIndex !== -1) {
                    this.products[existingIndex].quantity = Number(this.products[existingIndex].quantity) + Number(item.quantity);
                    this.calculate(existingIndex);
                    this.products.splice(index, 1);
                    return;
                }
            }
            this.calculate(index);
        },
        addVariant(index, vName) {
            let item = this.products[index];
            let vData = item.all_variations[vName];

            // Check for duplicates (Variation Products)
            let existingIndex = this.products.findIndex((p, idx) => 
                idx !== index && 
                p.product_id == item.product_id && 
                p.variation_name === vName
            );

            if (existingIndex !== -1) {
                this.products[existingIndex].quantity = Number(this.products[existingIndex].quantity) + Number(item.quantity);
                this.calculate(existingIndex);
                this.products.splice(index, 1);
                return;
            }

            item.variation_name = vName;
            item.price = vData.price || 0;
            item.stock = vData.opening_stock || 0;
            this.calculate(index);
        },
        calculate(index) {
            let item = this.products[index];
            item.total = Number(item.quantity) * Number(item.price);
            this.calculateTotals();
        },
        calculateTotals() {
            this.subtotal = this.products.reduce((sum, item) => sum + (parseFloat(item.total) || 0), 0);
            let discountVal = parseFloat(this.discount) || 0;

            // Cap tax at 100%
            this.tax_percent = Math.min(100, parseFloat(this.tax_percent) || 0);
            let taxRate = this.tax_percent;

            this.tax = (this.subtotal - discountVal) * (taxRate / 100);
            // Ensure Grand Total is never negative
            this.grandTotal = Math.max(0, this.subtotal - discountVal + this.tax);
        }
    }
}
</script>

@endsection
