@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Sale Returns</h1>
        <p class="text-gray-500 text-sm">Manage all customer sale returns</p>
    </div>

</div>

<x-card>

    <x-table>

        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">#</th>
                <th class="p-4 text-left">Return No</th>
                <th class="p-4 text-left">Sale Invoice</th>
                <th class="p-4 text-left">Customer</th>
                <th class="p-4 text-left">Return Date</th>
                <th class="p-4 text-left">Items</th>
                <th class="p-4 text-left">Total</th>
                <th class="p-4 text-center">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($returns as $return)

                <tr class="border-t hover:bg-gray-50 transition">

                    <td class="p-4 text-gray-500">
                        {{ $loop->iteration + ($returns->currentPage() - 1) * $returns->perPage() }}
                    </td>

                    <td class="p-4 font-semibold text-gray-800">
                        {{ $return->return_no }}
                    </td>

                    <td class="p-4">
                        <a href="{{ route('sales.show', $return->sale_id) }}"
                           class="text-blue-600 hover:underline font-medium">
                            {{ $return->sale->invoice_no }}
                        </a>
                    </td>

                    <td class="p-4 text-gray-700">
                        {{ $return->sale->customer->name ?? 'Walk-in Customer' }}
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ date('d M Y', strtotime($return->return_date)) }}
                    </td>

                    <td class="p-4 text-gray-700">
                        {{ $return->items->count() }} item(s)
                    </td>

                    <td class="p-4 font-semibold text-red-600">
                        ₹{{ number_format($return->total, 2) }}
                    </td>

                    <td class="p-4 text-center">

                        <div
                            x-data="{ openMenu: false, openDeleteModal: false }"
                            class="relative inline-block text-left"
                        >

                            {{-- 3-dot button --}}
                            <button
                                @click="openMenu = !openMenu"
                                class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 5h.01M12 12h.01M12 19h.01"/>
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div
                                x-show="openMenu"
                                @click.away="openMenu = false"
                                x-transition
                                class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border z-50 overflow-hidden"
                                style="display: none;"
                            >

                                {{-- View --}}
                                <a href="{{ route('sale-returns.show', $return->id) }}"
                                   class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="font-medium text-gray-700">View</span>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('sale-returns.edit', $return->id) }}"
                                   class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    <span class="font-medium text-gray-700">Edit</span>
                                </a>

                                {{-- Delete --}}
                                <button
                                    @click="openDeleteModal = true; openMenu = false"
                                    class="w-full flex items-center gap-3 px-5 py-3 hover:bg-red-50 text-red-500 transition text-left"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span class="font-medium">Delete</span>
                                </button>

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
                                    <h2 class="text-xl font-bold text-gray-800 mb-3">Delete Sale Return</h2>

                                    <p class="text-gray-500 mb-6">
                                        Are you sure you want to delete return
                                        <strong>{{ $return->return_no }}</strong>?
                                        <br><br>
                                        <span class="text-red-500 font-medium">
                                            Stock that was restored will be deducted again.
                                        </span>
                                    </p>

                                    <div class="flex justify-end gap-3">
                                        <button
                                            @click="openDeleteModal = false"
                                            class="px-4 py-2 border rounded-lg hover:bg-gray-100"
                                        >Cancel</button>

                                        <form
                                            action="{{ route('sale-returns.destroy', $return->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg"
                                            >Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="p-8 text-center text-gray-500">
                        No sale returns found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">
        {{ $returns->links() }}
    </div>

</x-card>

@endsection
