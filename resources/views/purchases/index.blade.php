@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Purchases
        </h1>

        <p class="text-gray-500 text-sm">
            Manage all purchase invoices
        </p>

    </div>

    @can('create_purchase')
        <a href="{{ route('purchases.create') }}">
            <x-button>
                + Add Purchase
            </x-button>
        </a>
    @endcan

</div>

<x-card>

    <x-table>

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Invoice
                </th>

                <th class="p-4 text-left">
                    Supplier
                </th>

                <th class="p-4 text-left">
                    Date
                </th>

                <th class="p-4 text-left">
                    Total
                </th>

                <th class="p-4 text-left">
                    Paid
                </th>

                <th class="p-4 text-left">
                    Due
                </th>

                <th class="p-4 text-left">
                    Payment
                </th>

                <th class="p-4 text-center">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($purchases as $purchase)

                <tr class="border-t hover:bg-gray-50 transition">

                    {{-- Invoice --}}
                    <td class="p-4 font-semibold text-gray-800">
                        {{ $purchase->invoice_no }}
                    </td>

                    {{-- Supplier --}}
                    <td class="p-4">

                        <div class="font-medium text-gray-800">
                            {{ $purchase->supplier->name }}
                        </div>

                    </td>

                    {{-- Date --}}
                    <td class="p-4 text-gray-600">

                        {{ date('d M Y', strtotime($purchase->purchase_date)) }}

                    </td>

                    {{-- Total --}}
                    <td class="p-4 font-semibold text-gray-800">

                        ₹{{ number_format($purchase->total, 2) }}

                    </td>

                    {{-- Paid --}}
                    <td class="p-4 font-semibold text-green-600">

                        ₹{{ number_format($purchase->paid_amount, 2) }}

                    </td>

                    {{-- Due --}}
                    <td class="p-4 font-semibold text-red-600">

                        ₹{{ number_format($purchase->due_amount, 2) }}

                    </td>

                    {{-- Payment Status --}}
                    <td class="p-4">

                        @if($purchase->payment_status == 'paid')

                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-medium">

                                Paid

                            </span>

                        @elseif($purchase->payment_status == 'partial')

                            <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm font-medium">

                                Partial

                            </span>

                        @else

                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm font-medium">

                                Due

                            </span>

                        @endif

                    </td>

                    {{-- Actions --}}
                    <td class="p-4 text-center">

                        <div
                            x-data="{ openActionMenu: false, openDeleteModal: false }"
                            class="relative inline-block text-left"
                        >

                            {{-- 3 Dot Button --}}
                            <button
                                @click="openActionMenu = !openActionMenu"
                                class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-gray-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 5h.01M12 12h.01M12 19h.01"
                                    />

                                </svg>

                            </button>

                            {{-- Dropdown --}}
                            <div
                                x-show="openActionMenu"
                                @click.away="openActionMenu = false"
                                x-transition
                                class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border z-50 overflow-hidden"
                                style="display: none;"
                            >

                                {{-- View --}}
                                <a
                                    href="{{ route('purchases.show', $purchase->id) }}"
                                    class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition"
                                >


                                    <span class="font-medium">
                                        View Purchase
                                    </span>

                                </a>


                                {{-- Create Purchase Return --}}
                                @can('create_purchase_return')
                                    <a
                                        href="{{ route('purchase-returns.create', $purchase->id) }}"
                                        class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition"
                                    >
                                        <span class="font-medium">
                                            Create Purchase Return
                                        </span>
                                    </a>
                                @endcan


                                {{-- Edit --}}
                                @can('update_purchase')
                                    <a
                                        href="{{ route('purchases.edit', $purchase->id) }}"
                                        class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition"
                                    >
                                        <span class="font-medium">
                                            Edit Purchase
                                        </span>
                                    </a>
                                @endcan

                                {{-- PDF --}}
                                <button
                                    class="w-full flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition text-left"
                                >


                                    <span class="font-medium">
                                        Download PDF
                                    </span>

                                </button>

                                {{-- Delete --}}
                                @can('delete_purchase')
                                    <button
                                        @click="
                                            openDeleteModal = true;
                                            openActionMenu = false;
                                        "
                                        class="w-full flex items-center gap-3 px-5 py-3 hover:bg-red-50 text-red-500 transition text-left"
                                    >
                                        <span class="font-medium">
                                            Delete Purchase
                                        </span>
                                    </button>
                                @endcan

                            </div>

                            {{-- Delete Modal --}}
                            <div
                                x-show="openDeleteModal"
                                class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
                                style="display: none;"
                            >

                                <div
                                    @click.away="openDeleteModal = false"
                                    class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6"
                                >

                                    <h2 class="text-xl font-bold text-gray-800 mb-3">
                                        Delete Purchase
                                    </h2>

                                    <p class="text-gray-500 mb-6">

                                        Are you sure you want to delete this purchase?

                                        <br><br>

                                        <span class="text-red-500 font-medium">
                                            This action will decrease stock.
                                        </span>

                                    </p>

                                    <div class="flex justify-end gap-3">

                                        <button
                                            @click="openDeleteModal = false"
                                            class="px-4 py-2 border rounded-lg hover:bg-gray-100"
                                        >
                                            Cancel
                                        </button>

                                        <form
                                            action="{{ route('purchases.destroy', $purchase->id) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="p-6 text-center text-gray-500">

                        No Purchases Found

                    </td>

                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">

        {{ $purchases->links() }}

    </div>

</x-card>

@endsection