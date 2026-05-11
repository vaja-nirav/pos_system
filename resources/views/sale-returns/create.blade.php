@extends('layouts.app')

@section('content')

<div x-data="saleReturnHandler()" class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Create Sale Return</h1>
            <p class="text-gray-500 text-sm">Return items from Sale: <strong>{{ $sale->invoice_no }}</strong></p>
        </div>
        <a href="{{ route('sale-returns.index') }}">
            <x-button>← Back</x-button>
        </a>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('sale-returns.store') }}" method="POST">
        @csrf

        <input type="hidden" name="sale_id" value="{{ $sale->id }}">

        {{-- Sale Info --}}
        <x-card>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-600">Customer</label>
                    <x-input value="{{ $sale->customer->name ?? 'Walk-in Customer' }}" readonly />
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-600">Invoice No</label>
                    <x-input value="{{ $sale->invoice_no }}" readonly />
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-600">Sale Date</label>
                    <x-input value="{{ date('d M Y', strtotime($sale->sale_date)) }}" readonly />
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-600">Return Date <span class="text-red-500">*</span></label>
                    <x-input
                        type="date"
                        name="return_date"
                        value="{{ old('return_date', date('Y-m-d')) }}"
                    />
                    @error('return_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </x-card>

        {{-- Products Table --}}
        <x-card class="mt-6">

            <h3 class="text-base font-semibold text-gray-700 mb-4">Select Items to Return</h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-left w-12">
                                <input
                                    type="checkbox"
                                    @change="toggleAll($event)"
                                    class="w-4 h-4 rounded"
                                    title="Select All"
                                >
                            </th>
                            <th class="p-4 text-left">Product</th>
                            <th class="p-4 text-left">Sold Qty</th>
                            <th class="p-4 text-left">Return Qty</th>
                            <th class="p-4 text-left">Unit Price (₹)</th>
                            <th class="p-4 text-left">Subtotal (₹)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sale->items as $index => $item)
                        <tr class="border-t" :class="products[{{ $index }}].selected ? 'bg-blue-50' : 'hover:bg-gray-50'">

                            <td class="p-4">
                                <input
                                    type="checkbox"
                                    x-model="products[{{ $index }}].selected"
                                    @change="onToggle({{ $index }})"
                                    class="w-4 h-4 rounded"
                                >
                            </td>

                            <td class="p-4 font-medium text-gray-800">
                                {{ $item->product->name }}
                                <input type="hidden" name="products[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ $item->quantity }}
                            </td>

                            <td class="p-4">
                                <input
                                    type="number"
                                    name="products[{{ $index }}][qty]"
                                    x-model="products[{{ $index }}].qty"
                                    @input="calculate({{ $index }})"
                                    :disabled="!products[{{ $index }}].selected"
                                    min="0"
                                    max="{{ $item->quantity }}"
                                    class="w-24 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none disabled:bg-gray-100 disabled:text-gray-400"
                                >
                                @error("products.{$index}.qty")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </td>

                            <td class="p-4">
                                <input
                                    type="number"
                                    step="0.01"
                                    name="products[{{ $index }}][price]"
                                    x-model="products[{{ $index }}].price"
                                    @input="calculate({{ $index }})"
                                    :disabled="!products[{{ $index }}].selected"
                                    class="w-28 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none disabled:bg-gray-100 disabled:text-gray-400"
                                >
                            </td>

                            <td class="p-4">
                                <span
                                    x-text="'₹' + Number(products[{{ $index }}].subtotal).toFixed(2)"
                                    class="font-semibold text-gray-800"
                                ></span>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </x-card>

        {{-- Totals & Note --}}
        <x-card class="mt-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-600">Note (Optional)</label>
                    <textarea
                        name="note"
                        rows="3"
                        placeholder="Reason for return..."
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('note') }}</textarea>
                </div>

                <div class="flex flex-col justify-end">

                    <div class="bg-gray-50 border rounded-xl p-4 space-y-3">

                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Selected Items</span>
                            <span x-text="selectedCount + ' item(s)'" class="font-medium"></span>
                        </div>

                        <div class="flex justify-between items-center border-t pt-3">
                            <span class="font-semibold text-gray-700">Total Return Amount</span>
                            <span
                                x-text="'₹' + Number(grandTotal).toFixed(2)"
                                class="text-xl font-bold text-red-600"
                            ></span>
                        </div>

                        <input type="hidden" name="total" x-bind:value="grandTotal">

                    </div>

                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <x-button type="submit">Submit Return</x-button>
                <a href="{{ route('sale-returns.index') }}">
                    <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-sm font-medium">
                        Cancel
                    </button>
                </a>
            </div>

        </x-card>

    </form>

</div>

<script>
function saleReturnHandler() {
    return {
        products: [
            @foreach($sale->items as $item)
            {
                selected: false,
                qty: 0,
                price: {{ $item->price }},
                subtotal: 0,
                maxQty: {{ $item->quantity }},
            },
            @endforeach
        ],

        grandTotal: 0,
        selectedCount: 0,

        toggleAll(event) {
            const checked = event.target.checked;
            this.products.forEach((p, i) => {
                p.selected = checked;
                if (checked && p.qty == 0) {
                    p.qty = p.maxQty;
                }
                this.calculate(i);
            });
        },

        onToggle(index) {
            const p = this.products[index];
            if (p.selected && p.qty == 0) {
                p.qty = p.maxQty;
            }
            if (!p.selected) {
                p.qty = 0;
                p.subtotal = 0;
            }
            this.calculateTotals();
        },

        calculate(index) {
            const p = this.products[index];
            if (p.qty > p.maxQty) p.qty = p.maxQty;
            if (p.qty < 0) p.qty = 0;
            p.subtotal = p.selected ? (p.qty * p.price) : 0;
            this.calculateTotals();
        },

        calculateTotals() {
            this.grandTotal = this.products.reduce((sum, p) => sum + Number(p.subtotal), 0);
            this.selectedCount = this.products.filter(p => p.selected && p.qty > 0).length;
        },
    }
}
</script>

@endsection
