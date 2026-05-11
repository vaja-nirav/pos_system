@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Stock Report
        </h1>

        <p class="text-gray-500">
            Product stock overview
        </p>

    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="pb-3 text-left">
                            Product
                        </th>

                        <th class="pb-3 text-left">
                            SKU
                        </th>

                        <th class="pb-3 text-left">
                            Stock
                        </th>

                        <th class="pb-3 text-left">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($products as $product)

                        <tr class="border-b">

                            <td class="py-4">

                                {{ $product->name }}

                            </td>

                            <td class="py-4">

                                {{ $product->sku }}

                            </td>

                            <td class="py-4 font-semibold">

                                {{ $product->current_stock }}

                            </td>

                            <td class="py-4">

                                @if($product->current_stock <= 0)

                                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm">

                                        Out of Stock

                                    </span>

                                @elseif($product->current_stock <= 10)

                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm">

                                        Low Stock

                                    </span>

                                @else

                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">

                                        In Stock

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-6">

            {{ $products->links() }}

        </div>

    </div>

</div>

@endsection