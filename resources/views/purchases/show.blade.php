@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Purchase Details
            </h1>

            <p class="text-gray-500 text-sm">

                Invoice:
                {{ $purchase->invoice_no }}

            </p>

        </div>

        <a href="{{ route('purchases.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    {{-- Purchase Info --}}
    <x-card>

        <div class="grid grid-cols-4 gap-6">

            <div>

                <p class="text-gray-500 text-sm">
                    Supplier
                </p>

                <h3 class="font-semibold text-lg">

                    {{ $purchase->supplier->name }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Purchase Date
                </p>

                <h3 class="font-semibold text-lg">

                    {{ date('d M Y', strtotime($purchase->purchase_date)) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Payment Status
                </p>

                <h3 class="font-semibold text-lg capitalize">

                    {{ $purchase->payment_status }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Total Amount
                </p>

                <h3 class="font-semibold text-lg">

                    ₹{{ number_format($purchase->total, 2) }}

                </h3>

            </div>

        </div>

    </x-card>

    {{-- Purchase Items --}}
    <x-card class="mt-6">

        <x-table>

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

                </tr>

            </thead>

            <tbody>

                @foreach($purchase->items as $item)

                    <tr class="border-t">

                        <td class="p-4">

                            {{ $item->product->name }}

                        </td>

                        <td class="p-4">

                            {{ $item->quantity }}

                        </td>

                        <td class="p-4">

                            ₹{{ number_format($item->cost_price, 2) }}

                        </td>

                        <td class="p-4">

                            ₹{{ number_format($item->total, 2) }}

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </x-table>

    </x-card>

    {{-- Totals --}}
    <x-card class="mt-6">

        <div class="grid grid-cols-4 gap-6">

            <div>

                <p class="text-gray-500 text-sm">
                    Subtotal
                </p>

                <h3 class="font-semibold text-lg">

                    ₹{{ number_format($purchase->subtotal, 2) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Tax
                </p>

                <h3 class="font-semibold text-lg">

                    ₹{{ number_format($purchase->tax, 2) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Discount
                </p>

                <h3 class="font-semibold text-lg">

                    ₹{{ number_format($purchase->discount, 2) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Grand Total
                </p>

                <h3 class="font-bold text-2xl text-green-600">

                    ₹{{ number_format($purchase->total, 2) }}

                </h3>

            </div>

        </div>

    </x-card>

</div>

@endsection