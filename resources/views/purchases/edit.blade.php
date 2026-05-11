@extends('layouts.app')

@section('content')

<div
    x-data="purchaseHandler()"
    class="max-w-7xl mx-auto"
>

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Purchase
            </h1>

            <p class="text-gray-500 text-sm">
                Update purchase invoice
            </p>

        </div>

        <a href="{{ route('purchases.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <form
        action="{{ route('purchases.update', $purchase->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <x-card>

            <div class="grid grid-cols-4 gap-6 mb-6">

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
                                {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}
                            >

                                {{ $supplier->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Invoice --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Invoice No
                    </label>

                    <x-input
                        type="text"
                        name="invoice_no"
                        value="{{ old('invoice_no', $purchase->invoice_no) }}"
                    />

                </div>

                {{-- Purchase Date --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Purchase Date
                    </label>

                    <x-input
                        type="date"
                        name="purchase_date"
                        value="{{ old('purchase_date', $purchase->purchase_date) }}"
                    />

                </div>

                {{-- Payment Status --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Payment Status
                    </label>

                    <select
                        name="payment_status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                        <option value="paid" {{ $purchase->payment_status == 'paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                        <option value="partial" {{ $purchase->payment_status == 'partial' ? 'selected' : '' }}>
                            Partial
                        </option>

                        <option value="due" {{ $purchase->payment_status == 'due' ? 'selected' : '' }}>
                            Due
                        </option>

                    </select>

                </div>

            </div>

        </x-card>

        {{-- Products --}}
        <x-card class="mt-6">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="p-4 text-left">
                                Product
                            </th>

                            <th class="p-4 text-left">
                                Qty
                            </th>

                            <th class="p-4 text-left">
                                Cost Price
                            </th>

                            <th class="p-4 text-left">
                                Total
                            </th>

                            <th class="p-4 text-left">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <template x-for="(item, index) in products">

                            <tr class="border-t">

                                {{-- Product --}}
                                <td class="p-4">

                                    <select
                                        :name="'products[' + index + '][product_id]'"
                                        x-model="item.product_id"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                    >

                                        <option value="">
                                            Select Product
                                        </option>

                                        @foreach($products as $product)

                                            <option value="{{ $product->id }}">

                                                {{ $product->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </td>

                                {{-- Qty --}}
                                <td class="p-4">

                                    <input
                                        type="number"
                                        min="1"
                                        x-model="item.quantity"
                                        @input="calculate(index)"
                                        :name="'products[' + index + '][quantity]'"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                    >

                                </td>

                                {{-- Cost Price --}}
                                <td class="p-4">

                                    <input
                                        type="number"
                                        step="0.01"
                                        x-model="item.cost_price"
                                        @input="calculate(index)"
                                        :name="'products[' + index + '][cost_price]'"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                    >

                                </td>

                                {{-- Total --}}
                                <td class="p-4">

                                    <input
                                        type="number"
                                        step="0.01"
                                        x-model="item.total"
                                        :name="'products[' + index + '][total]'"
                                        readonly
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100"
                                    >

                                </td>

                                {{-- Remove --}}
                                <td class="p-4">

                                    <button
                                        type="button"
                                        @click="removeRow(index)"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg"
                                    >
                                        Remove
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
                class="mt-5 px-4 py-2 bg-blue-500 text-white rounded-lg"
            >
                + Add Product
            </button>

        </x-card>

        {{-- Totals --}}
        <x-card class="mt-6">

            <div class="grid grid-cols-4 gap-6">

                <div>

                    <label class="block mb-2 font-medium">
                        Subtotal
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        x-model="subtotal"
                        name="subtotal"
                        readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Tax
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        x-model="tax"
                        @input="calculateTotals()"
                        name="tax"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Discount
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        x-model="discount"
                        @input="calculateTotals()"
                        name="discount"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Total
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        x-model="grandTotal"
                        name="total"
                        readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100"
                    >

                </div>

            </div>

            <div class="grid grid-cols-3 gap-6 mt-6">

                <div>

                    <label class="block mb-2 font-medium">
                        Paid Amount
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        x-model="paidAmount"
                        @input="calculateDue()"
                        name="paid_amount"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Due Amount
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        x-model="dueAmount"
                        name="due_amount"
                        readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                        <option value="1" {{ $purchase->status == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ $purchase->status == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

            <div class="mt-6">

                <x-button type="submit">
                    Update Purchase
                </x-button>

            </div>

        </x-card>

    </form>

</div>

<script>

function purchaseHandler()
{
    return {

        products: {!! json_encode($purchase->items->map(function($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'cost_price' => $item->cost_price,
                'total' => $item->total,
            ];
        })) !!},

        subtotal: {{ $purchase->subtotal }},
        tax: {{ $purchase->tax }},
        discount: {{ $purchase->discount }},
        grandTotal: {{ $purchase->total }},
        paidAmount: {{ $purchase->paid_amount }},
        dueAmount: {{ $purchase->due_amount }},

        addRow()
        {
            this.products.push({
                product_id: '',
                quantity: 1,
                cost_price: 0,
                total: 0
            });
        },

        removeRow(index)
        {
            this.products.splice(index, 1);

            this.calculateTotals();
        },

        calculate(index)
        {
            let item = this.products[index];

            item.total =
                item.quantity * item.cost_price;

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
                + Number(this.tax)
                - Number(this.discount);

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