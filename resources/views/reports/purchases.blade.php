@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Purchases Report
        </h1>

        <p class="text-gray-500">
            View all purchases reports
        </p>

    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <form class="grid grid-cols-4 gap-6">

            <div>

                <label class="block mb-2 font-medium">
                    From Date
                </label>

                <input
                    type="date"
                    name="from_date"
                    value="{{ request('from_date') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    To Date
                </label>

                <input
                    type="date"
                    name="to_date"
                    value="{{ request('to_date') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

            </div>

            <div class="flex items-end">

                <button
                    class="px-6 py-3 bg-blue-500 text-white rounded-xl"
                >
                    Filter
                </button>

            </div>

        </form>

    </div>

    {{-- Card --}}
    <div class="grid grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <p class="text-gray-500 text-sm">
                Total Purchases
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">

                ₹{{ number_format($totalPurchases, 2) }}

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
                            Invoice
                        </th>

                        <th class="pb-3 text-left">
                            Date
                        </th>

                        <th class="pb-3 text-left">
                            Total
                        </th>

                        <th class="pb-3 text-left">
                            Payment
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($purchases as $purchase)

                        <tr class="border-b">

                            <td class="py-4 font-semibold">

                                {{ $purchase->invoice_no }}

                            </td>

                            <td class="py-4">

                                {{ $purchase->purchase_date }}

                            </td>

                            <td class="py-4 text-green-600 font-semibold">

                                ₹{{ number_format($purchase->total, 2) }}

                            </td>

                            <td class="py-4">

                                @if($purchase->payment_status == 'paid')

                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">

                                        Paid

                                    </span>

                                @elseif($purchase->payment_status == 'partial')

                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm">

                                        Partial

                                    </span>

                                @else

                                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm">

                                        Due

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="py-6 text-center text-gray-500">

                                No Purchases Found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-6">

            {{ $purchases->links() }}

        </div>

    </div>

</div>

@endsection