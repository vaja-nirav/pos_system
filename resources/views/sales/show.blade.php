@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Sale Details
            </h1>

            <p class="text-gray-500 text-sm">

                Invoice:
                {{ $sale->invoice_no }}

            </p>

        </div>

        <a href="{{ route('sales.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    {{-- Sale Info --}}
    <x-card>

        <div class="grid grid-cols-4 gap-6">

            <div>

                <p class="text-gray-500 text-sm">
                    Customer
                </p>

                <h3 class="font-semibold text-lg">

                    {{ $sale->customer->name ?? 'Walk-in Customer' }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Sale Date
                </p>

                <h3 class="font-semibold text-lg">

                    {{ date('d M Y', strtotime($sale->sale_date)) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Payment Status
                </p>

                <h3 class="font-semibold text-lg capitalize">

                    {{ $sale->payment_status }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Total Amount
                </p>

                <h3 class="font-semibold text-lg">

                    ₹{{ number_format($sale->total, 2) }}

                </h3>

            </div>

        </div>

    </x-card>

    {{-- Sale Items --}}
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
                        Price
                    </th>

                    <th class="p-4 text-left">
                        Total
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($sale->items as $item)

                    <tr class="border-t">

                        <td class="p-4">

                            {{ $item->product->name }}

                        </td>

                        <td class="p-4">

                            {{ $item->quantity }}

                        </td>

                        <td class="p-4">

                            ₹{{ number_format($item->price, 2) }}

                        </td>

                        <td class="p-4">

                            ₹{{ number_format($item->subtotal, 2) }}

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

                    ₹{{ number_format($sale->subtotal, 2) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Tax
                </p>

                <h3 class="font-semibold text-lg">

                    ₹{{ number_format($sale->tax, 2) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Discount
                </p>

                <h3 class="font-semibold text-lg">

                    ₹{{ number_format($sale->discount, 2) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">
                    Grand Total
                </p>

                <h3 class="font-bold text-2xl text-green-600">

                    ₹{{ number_format($sale->total, 2) }}

                </h3>

            </div>

        </div>

    </x-card>

</div>

@endsection
