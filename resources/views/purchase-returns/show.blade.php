@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Purchase Return Details</h1>
            <p class="text-gray-500 text-sm">Return No: <strong>{{ $return->return_no }}</strong></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('purchase-returns.edit', $return->id) }}">
                <x-button>Edit</x-button>
            </a>
            <a href="{{ route('purchase-returns.index') }}">
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-sm font-medium">
                    ← Back
                </button>
            </a>
        </div>
    </div>

    {{-- Return Info --}}
    <x-card>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            <div>
                <p class="text-gray-500 text-sm mb-1">Return No</p>
                <h3 class="font-semibold text-lg text-gray-800">{{ $return->return_no }}</h3>
            </div>

            <div>
                <p class="text-gray-500 text-sm mb-1">Purchase Invoice</p>
                <a href="{{ route('purchases.show', $return->purchase_id) }}"
                   class="font-semibold text-lg text-blue-600 hover:underline">
                    {{ $return->purchase->invoice_no }}
                </a>
            </div>

            <div>
                <p class="text-gray-500 text-sm mb-1">Supplier</p>
                <h3 class="font-semibold text-lg text-gray-800">{{ $return->purchase->supplier->name }}</h3>
            </div>

            <div>
                <p class="text-gray-500 text-sm mb-1">Return Date</p>
                <h3 class="font-semibold text-lg text-gray-800">
                    {{ date('d M Y', strtotime($return->return_date)) }}
                </h3>
            </div>

        </div>

        @if($return->note)
            <div class="mt-4 pt-4 border-t">
                <p class="text-gray-500 text-sm mb-1">Note</p>
                <p class="text-gray-700">{{ $return->note }}</p>
            </div>
        @endif

    </x-card>

    {{-- Return Items --}}
    <x-card class="mt-6">

        <h3 class="text-base font-semibold text-gray-700 mb-4">Returned Items</h3>

        <x-table>

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">#</th>
                    <th class="p-4 text-left">Product</th>
                    <th class="p-4 text-left">Qty Returned</th>
                    <th class="p-4 text-left">Unit Price</th>
                    <th class="p-4 text-left">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($return->items as $item)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="p-4 font-medium text-gray-800">{{ $item->product->name }}</td>
                        <td class="p-4 text-gray-700">{{ $item->qty }}</td>
                        <td class="p-4 text-gray-700">₹{{ number_format($item->price, 2) }}</td>
                        <td class="p-4 font-semibold text-gray-800">₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>

        </x-table>

    </x-card>

    {{-- Total Summary --}}
    <x-card class="mt-6">

        <div class="flex justify-end">
            <div class="w-full max-w-xs space-y-3">

                <div class="flex justify-between text-sm text-gray-600">
                    <span>Total Items</span>
                    <span class="font-medium">{{ $return->items->count() }}</span>
                </div>

                <div class="flex justify-between items-center border-t pt-3">
                    <span class="font-semibold text-gray-700">Total Return Amount</span>
                    <span class="text-2xl font-bold text-red-600">
                        ₹{{ number_format($return->total, 2) }}
                    </span>
                </div>

            </div>
        </div>

    </x-card>

</div>

@endsection
