@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Suppliers
        </h1>

        <p class="text-gray-500 text-sm">
            Manage all suppliers
        </p>

    </div>

    <a href="{{ route('suppliers.create') }}">

        <x-button>
            + Add Supplier
        </x-button>

    </a>

</div>

<x-card>

    <x-table>

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Image
                </th>

                <th class="p-4 text-left">
                    Supplier
                </th>

                <th class="p-4 text-left">
                    Company
                </th>

                <th class="p-4 text-left">
                    Phone
                </th>

                <th class="p-4 text-left">
                    Status
                </th>

                <th class="p-4 text-left">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($suppliers as $supplier)

                <tr class="border-t">

                    {{-- Image --}}
                    <td class="p-4">

                        @if($supplier->getFirstMediaUrl('suppliers'))

                            <img
                                src="{{ $supplier->getFirstMediaUrl('suppliers') }}"
                                class="w-12 h-12 rounded-full object-cover"
                            >

                        @endif

                    </td>

                    {{-- Supplier --}}
                    <td class="p-4">

                        <div class="font-semibold">
                            {{ $supplier->name }}
                        </div>

                        <div class="text-sm text-gray-500">
                            {{ $supplier->email }}
                        </div>

                    </td>

                    {{-- Company --}}
                    <td class="p-4">
                        {{ $supplier->company_name ?? '-' }}
                    </td>

                    {{-- Phone --}}
                    <td class="p-4">
                        {{ $supplier->phone }}
                    </td>

                    {{-- Status --}}
                    <td class="p-4">

                        @if($supplier->status)

                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">
                                Active
                            </span>

                        @else

                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm">
                                Inactive
                            </span>

                        @endif

                    </td>

                    {{-- Action --}}
                    <td class="p-4">

                        <div class="flex gap-2">

                            <a href="{{ route('suppliers.edit', $supplier->id) }}">

                                <x-button>
                                    Edit
                                </x-button>

                            </a>

                            <div x-data="{ openDeleteModal: false }">

                                <button
                                    @click="openDeleteModal = true"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                >
                                    Delete
                                </button>

                                <div
                                    x-show="openDeleteModal"
                                    class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
                                    style="display: none;"
                                >

                                    <div
                                        @click.away="openDeleteModal = false"
                                        class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6"
                                    >

                                        <h2 class="text-xl font-bold mb-3">
                                            Delete Supplier
                                        </h2>

                                        <p class="text-gray-500 mb-6">
                                            Are you sure you want to delete this supplier?
                                        </p>

                                        <div class="flex justify-end gap-3">

                                            <button
                                                @click="openDeleteModal = false"
                                                class="px-4 py-2 border rounded-lg"
                                            >
                                                Cancel
                                            </button>

                                            <form
                                                action="{{ route('suppliers.destroy', $supplier->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white rounded-lg"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="p-6 text-center text-gray-500">
                        No Suppliers Found
                    </td>

                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">
        {{ $suppliers->links() }}
    </div>

</x-card>

@endsection