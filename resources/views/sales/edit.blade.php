@extends('layouts.app')

@section('content')

<div
    x-data="saleHandler()"
    class="max-w-7xl mx-auto"
>

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Sale
            </h1>

            <p class="text-gray-500 text-sm">
                Update sale invoice
            </p>

        </div>

        <a href="{{ route('sales.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <form
        action="{{ route('sales.update', $sale->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        {{-- Top Section --}}
        <x-card>

            <div class="grid grid-cols-4 gap-6">

                {{-- Invoice No (readonly) --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Invoice No
                    </label>

                    <x-input
                        type="text"
                        name="invoice_no"
                        value="{{ $sale->invoice_no }}"
                        readonly
                    />

                </div>

                {{-- Customer --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Customer
                    </label>

                    <select
                        name="customer_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                        <option value="">
                            Walk-in Customer
                        </option>

                        @foreach($customers as $customer)

                            <option
                                value="{{ $customer->id }}"
                                {{ $sale->customer_id == $customer->id ? 'selected' : '' }}
                            >

                                {{ $customer->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Sale Date --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Sale Date
                    </label>

                    <x-input
                        type="date"
                        name="sale_date"
                        value="{{ $sale->sale_date }}"
                    />

                </div>

                {{-- Payment --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Payment Status
                    </label>

                    <select
                        name="payment_status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                        <option value="paid" {{ $sale->payment_status == 'paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                        <option value="partial" {{ $sale->payment_status == 'partial' ? 'selected' : '' }}>
                            Partial
                        </option>

                        <option value="due" {{ $sale->payment_status == 'due' ? 'selected' : '' }}>
                            Due
                        </option>

                    </select>

                </div>

            </div>

        </x-card>

        {{-- Product Table --}}
        <x-card class="mt-6">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="p-4 text-left">
                                Product
                            </th>

                            <th class="p-4 text-left">
                                Stock
                            </th>

                            <th class="p-4 text-left">
                                Qty
                            </th>

                            <th class="p-4 text-left">
                                Price
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
                                        :name="'product_id[' + index + ']'"
                                        x-model="item.product_id"
                                        @change="setPrice(index)"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                    >

                                        <option value="">
                                            Select Product
                                        </option>

                                        @foreach($products as $product)

                                            <option
                                                value="{{ $product->id }}"
                                                data-price="{{ $product->selling_price }}"
                                                data-stock="{{ $product->current_stock }}"
                                            >

                                                {{ $product->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </td>

                                {{-- Stock --}}
                                <td class="p-4">

                                    <span
                                        class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm"
                                        x-text="item.stock"
                                    ></span>

                                </td>

                                {{-- Qty --}}
                                <td class="p-4">

                                    <input
                                        type="number"
                                        min="1"
                                        x-model="item.quantity"
                                        @input="calculate(index)"
                                        :name="'quantity[' + index + ']'"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                    >

                                </td>

                                {{-- Price --}}
                                <td class="p-4">

                                    <input
                                        type="number"
                                        step="0.01"
                                        x-model="item.price"
                                        @input="calculate(index)"
                                        :name="'price[' + index + ']'"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                    >

                                </td>

                                {{-- Total --}}
                                <td class="p-4">

                                    <input
                                        type="number"
                                        step="0.01"
                                        x-model="item.total"
                                        :name="'subtotal_item[' + index + ']'"
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

                {{-- Subtotal --}}
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

                {{-- Discount --}}
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

                {{-- Tax --}}
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

                {{-- Total --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Grand Total
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

                {{-- Paid --}}
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

                {{-- Due --}}
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

            </div>

            {{-- Note --}}
            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Note
                </label>

                <textarea
                    name="note"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >{{ $sale->note }}</textarea>

            </div>

            {{-- Submit --}}
            <div class="mt-6">

                <x-button type="submit">
                    Update Sale
                </x-button>

            </div>

        </x-card>

    </form>

</div>

<script>

function saleHandler()
{
    return {

        products: {!! json_encode($sale->items->map(function($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->subtotal, // subtotal in DB is item.total in Alpine
                'stock' => $item->product->current_stock + $item->quantity // Add back quantity to stock for correct validation when editing
            ];
        })) !!},

        subtotal: {{ $sale->subtotal }},
        discount: {{ $sale->discount }},
        tax: {{ $sale->tax }},
        grandTotal: {{ $sale->total }},
        paidAmount: {{ $sale->paid_amount }},
        dueAmount: {{ $sale->due_amount }},

        addRow()
        {
            this.products.push({
                product_id: '',
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
            // Note: index + 1 because the first <select> is the customer select!
            let select =
                document.querySelectorAll('select[name^="product_id"]')[index];

            if(!select) return;

            let option =
                select.options[select.selectedIndex];

            this.products[index].price =
                option.dataset.price || 0;

            this.products[index].stock =
                option.dataset.stock || 0;

            this.calculate(index);
        },

        calculate(index)
        {
            let item = this.products[index];

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
