@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Profit Report
        </h1>

        <p class="text-gray-500">
            View profit analytics
        </p>

    </div>

    {{-- Card --}}
    <div class="grid grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <p class="text-gray-500 text-sm">
                Total Profit
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">

                ₹{{ number_format($totalProfit, 2) }}

            </h2>

        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="pb-3 text-left">
                            Product
                        </th>

                        <th class="pb-3 text-left">
                            Qty
                        </th>

                        <th class="pb-3 text-left">
                            Sale Price
                        </th>

                        <th class="pb-3 text-left">
                            Profit
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($saleItems as $item)

                        <tr class="border-b">

                            <td class="py-4">

                                {{ $item->product->name }}

                            </td>

                            <td class="py-4">

                                {{ $item->quantity }}

                            </td>

                            <td class="py-4">

                                ₹{{ number_format($item->price, 2) }}

                            </td>

                            <td class="py-4 font-bold text-green-600">

                                ₹{{ number_format($item->profit, 2) }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-6">

            {{ $saleItems->links() }}

        </div>

    </div>

</div>

@endsection