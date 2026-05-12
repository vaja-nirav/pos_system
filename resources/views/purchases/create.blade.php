@extends('layouts.app')

@section('content')

<div
    x-data="purchaseHandler()"
    class="max-w-7xl mx-auto"
>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">
                Create Purchase
            </h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">Add new purchase invoice and restock items</p>
        </div>

        <a href="{{ route('purchases.index') }}">
            <x-button class="border border-gray-200 px-6 rounded-2xl font-bold">
                Back
            </x-button>
        </a>
    </div>

    <form
        action="{{ route('purchases.store') }}"
        method="POST"
        class="space-y-8"
    >
        @csrf

        {{-- Top Section --}}
        <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Supplier --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Supplier:*
                    </label>
                    <select
                        name="supplier_id"
                        required
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat font-bold text-gray-700"
                    >
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Invoice --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Invoice No:
                    </label>
                    <input
                        type="text"
                        name="invoice_no"
                        value="{{ $invoiceNo }}"
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700 bg-gray-50/50"
                        readonly
                    >
                </div>

                {{-- Date --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">
                        Purchase Date:*
                    </label>
                    <input
                        type="date"
                        name="purchase_date"
                        value="{{ date('Y-m-d') }}"
                        required
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
                        required
                        class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat font-bold text-gray-700"
                    >
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="due">Due</option>
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
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Product</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Stock</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Qty</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Cost Price</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="(item, index) in products">
                            <tr>
                                {{-- Product --}}
                                <td class="p-5 min-w-[280px]">
                                    <div class="space-y-1">
                                        <select
                                            :name="'products[' + index + '][product_id]'"
                                            x-model="item.product_id"
                                            @change="setPrice(index)"
                                            required
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22m6%208%204%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_1rem_center] bg-no-repeat font-bold text-gray-700"
                                        >
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option
                                                    value="{{ $product->id }}"
                                                    data-price="{{ $product->purchase_price }}"
                                                    data-stock="{{ $product->current_stock }}"
                                                    data-type="{{ $product->product_type }}"
                                                    data-variations='@json($product->variations)'
                                                >
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- Variation searchable Dropdown --}}
                                        <template x-if="item.product_type === 'variation'">
                                            <div class="pt-3 relative" x-data="{ open: false, search: '' }" :class="open ? 'z-[9999]' : ''">
                                                <button 
                                                    type="button"
                                                    @click="open = !open"
                                                    class="w-full flex items-center justify-between border border-indigo-100 bg-indigo-50/30 rounded-xl px-4 py-2.5 text-sm transition-all hover:border-indigo-300"
                                                    :class="open ? 'ring-2 ring-indigo-500/20 border-indigo-500' : ''"
                                                >
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-black text-[10px] uppercase tracking-wider text-indigo-600" x-text="item.variation || 'Choose Variant'"></span>
                                                        <template x-if="item.variation">
                                                            <span class="bg-indigo-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md uppercase tracking-tighter shadow-sm shadow-indigo-200">Selected</span>
                                                        </template>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                                </button>

                                                <div 
                                                    x-show="open" 
                                                    @click.away="open = false"
                                                    class="absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] z-[9999] overflow-hidden min-w-[220px]"
                                                >
                                                    <div class="p-3 border-b border-gray-50 bg-gray-50/30">
                                                        <input type="text" x-model="search" placeholder="Search variants..." class="w-full px-4 py-2 text-xs border border-gray-200 rounded-xl outline-none focus:border-indigo-500 transition-all">
                                                    </div>
                                                    <div class="max-h-60 overflow-y-auto py-1">
                                                        <template x-for="(vData, vName) in item.all_variations || {}" :key="vName">
                                                            <button 
                                                                type="button"
                                                                x-show="!search || vName.toLowerCase().includes(search.toLowerCase())"
                                                                @click="addVariant(index, vName); open = false"
                                                                class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-indigo-50/50 transition-colors group"
                                                            >
                                                                <span class="text-xs font-bold text-gray-700" x-text="vName"></span>
                                                                <span class="text-[10px] font-black text-indigo-500 bg-indigo-50 px-2 py-1 rounded-lg" x-text="'Stock: ' + (vData.opening_stock || 0)"></span>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                                <input type="hidden" :name="'products[' + index + '][variation]'" x-model="item.variation">
                                            </div>
                                        </template>
                                    </div>
                                </td>

                                {{-- Stock --}}
                                <td class="p-5 text-center">
                                    <span class="inline-block px-4 py-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl text-xs font-black shadow-sm" x-text="item.stock"></span>
                                </td>

                                {{-- Qty --}}
                                <td class="p-5">
                                    <input type="number" min="1" x-model="item.quantity" @input="calculateTotals()" :name="'products[' + index + '][quantity]'" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                                </td>

                                {{-- Cost Price --}}
                                <td class="p-5">
                                    <input type="number" step="0.01" x-model="item.cost_price" @input="calculateTotals()" :name="'products[' + index + '][cost_price]'" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                                </td>

                                {{-- Total --}}
                                <td class="p-5">
                                    <input type="number" step="0.01" :value="(item.quantity * item.cost_price).toFixed(2)" x-model="item.total" :name="'products[' + index + '][total]'" readonly class="w-full border border-gray-100 bg-gray-50/50 rounded-2xl px-5 py-3.5 outline-none font-bold text-gray-800">
                                </td>

                                {{-- Action --}}
                                <td class="p-5 text-center">
                                    <button type="button" @click="removeRow(index)" class="p-3.5 bg-red-50 text-red-500 border border-red-100 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <button type="button" @click="addRow()" class="mt-8 px-6 py-4 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-600 hover:text-white transition-all shadow-sm flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-white flex items-center justify-center text-indigo-600 shadow-sm">+</div>
                <span>Add New Product</span>
            </button>
        </x-card>

        {{-- Totals and Status --}}
        <x-card class="mt-8 border-none shadow-xl shadow-gray-100 rounded-3xl p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Subtotal --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Subtotal</label>
                    <input type="number" x-model="subtotal" name="subtotal" readonly class="w-full border border-gray-100 bg-gray-50/50 rounded-2xl px-5 py-3.5 outline-none font-black text-gray-800">
                </div>

                {{-- Tax --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Tax</label>
                    <input type="number" x-model="tax" @input="calculateTotals()" name="tax" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                </div>

                {{-- Discount --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Discount</label>
                    <input type="number" x-model="discount" @input="calculateTotals()" name="discount" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                </div>

                {{-- Grand Total --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-indigo-600 uppercase tracking-widest">Grand Total</label>
                    <input type="number" x-model="grandTotal" name="total" readonly class="w-full border border-indigo-100 bg-indigo-50/30 rounded-2xl px-5 py-3.5 outline-none font-black text-indigo-700 shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10 pt-10 border-t border-gray-50">
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Paid Amount:*</label>
                    <input type="number" x-model="paidAmount" @input="calculateDue()" name="paid_amount" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-indigo-600 bg-indigo-50/10">
                </div>
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Due Amount</label>
                    <input type="number" x-model="dueAmount" name="due_amount" readonly class="w-full border border-red-50 bg-red-50/30 rounded-2xl px-5 py-3.5 outline-none font-black text-red-600">
                </div>
                <div>
                    <label class="block mb-2 text-xs font-black text-gray-500 uppercase tracking-widest">Purchase Status:*</label>
                    <select name="status" class="w-full border border-gray-200 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-700">
                        <option value="1">Received</option>
                        <option value="0">Pending</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-12">
                <button type="submit" class="px-12 py-5 bg-indigo-500 text-white rounded-3xl font-black uppercase tracking-[0.2em] text-xs hover:bg-indigo-600 transition-all shadow-2xl shadow-indigo-200 active:scale-95">
                    Save Purchase
                </button>
            </div>
        </x-card>
    </form>
</div>

<script>
function purchaseHandler() {
    return {
        products: [{
            product_id: '',
            product_type: 'single',
            variation: '',
            all_variations: {},
            quantity: 1,
            cost_price: 0,
            total: 0,
            stock: 0
        }],
        subtotal: 0,
        tax: 0,
        discount: 0,
        grandTotal: 0,
        paidAmount: 0,
        dueAmount: 0,

        addRow() {
            this.products.push({
                product_id: '',
                product_type: 'single',
                variation: '',
                all_variations: {},
                quantity: 1,
                cost_price: 0,
                total: 0,
                stock: 0
            });
        },

        removeRow(index) {
            this.products.splice(index, 1);
            this.calculateTotals();
        },

        setPrice(index) {
            let select = document.querySelectorAll('select[name$="[product_id]"]')[index];
            if(!select) return;
            let option = select.options[select.selectedIndex];
            let item = this.products[index];
            
            if(!option.value) return;

            item.product_type = option.dataset.type || 'single';
            item.all_variations = JSON.parse(option.dataset.variations || '{}');
            
            if (item.product_type === 'variation') {
                item.cost_price = 0;
                item.stock = 0;
                item.variation = '';
            } else {
                item.cost_price = option.dataset.price || 0;
                item.stock = option.dataset.stock || 0;
            }
            this.calculateTotals();
        },

        addVariant(index, vName) {
            let currentItem = this.products[index];
            let vData = currentItem.all_variations[vName];

            // Check if exists
            let existingItem = this.products.find(p => 
                p.product_id === currentItem.product_id && 
                p.variation === vName
            );

            if (existingItem) {
                existingItem.quantity = Number(existingItem.quantity) + 1;
                if (!currentItem.variation && currentItem !== existingItem) {
                    this.removeRow(index);
                }
                this.calculateTotals();
                return;
            }

            if (!currentItem.variation) {
                currentItem.variation = vName;
                currentItem.cost_price = vData.price || 0;
                currentItem.stock = vData.opening_stock || 0;
            } else {
                this.products.splice(index + 1, 0, {
                    product_id: currentItem.product_id,
                    product_type: 'variation',
                    variation: vName,
                    all_variations: currentItem.all_variations,
                    quantity: 1,
                    cost_price: vData.price || 0,
                    stock: vData.opening_stock || 0,
                    total: vData.price || 0
                });
            }
            this.calculateTotals();
        },

        calculateTotals() {
            this.products.forEach(item => {
                item.total = Number(item.quantity) * Number(item.cost_price);
            });
            this.subtotal = this.products.reduce((sum, item) => sum + item.total, 0);
            this.grandTotal = Number(this.subtotal) + Number(this.tax) - Number(this.discount);
            this.calculateDue();
        },

        calculateDue() {
            if (Number(this.paidAmount) > Number(this.grandTotal)) {
                this.paidAmount = this.grandTotal;
                toastr.error('Paid amount cannot exceed grand total');
            }
            this.dueAmount = Number(this.grandTotal) - Number(this.paidAmount);
        }
    }
}
</script>
@endsection