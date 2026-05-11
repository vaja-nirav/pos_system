@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Brands
        </h1>

        <p class="text-gray-500 text-sm">
            Manage all brands
        </p>

    </div>

    <a href="{{ route('brands.create') }}">

        <x-button>
            + Add Brand
        </x-button>

    </a>

</div>

<x-card>

    <x-table>

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    ID
                </th>

                <th class="p-4 text-left">
                    Name
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

            @forelse($brands as $brand)

                <tr class="border-t">

                    <td class="p-4">
                        {{ $brand->id }}
                    </td>

                    <td class="p-4">

                        <div class="flex items-center gap-3">

                            @if($brand->getFirstMediaUrl('brands'))

                                <img
                                    src="{{ $brand->getFirstMediaUrl('brands') }}"
                                    class="w-12 h-12 rounded-lg object-cover"
                                    alt="{{ $brand->name }}"
                                >

                            @endif

                            {{ $brand->name }}

                        </div>

                    </td>

                    <td class="p-4">

                        @if($brand->status)

                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">
                                Active
                            </span>

                        @else

                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm">
                                Inactive
                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        <div class="flex gap-2">

                            <a href="{{ route('brands.edit', $brand->id) }}">

                                <x-button>
                                    Edit
                                </x-button>

                            </a>

                            <div x-data="{ openDeleteModal: false }">

                                <button
                                    @click="openDeleteModal = true"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
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

                                        <h2 class="text-xl font-bold text-gray-800 mb-3">
                                            Delete Brand
                                        </h2>

                                        <p class="text-gray-500 mb-6">
                                            Are you sure you want to delete this brand?
                                        </p>

                                        <div class="flex justify-end gap-3">

                                            <button
                                                @click="openDeleteModal = false"
                                                class="px-4 py-2 border rounded-lg"
                                            >
                                                Cancel
                                            </button>

                                            <form
                                                action="{{ route('brands.destroy', $brand->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
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

                    <td colspan="4" class="p-6 text-center text-gray-500">
                        No Brands Found
                    </td>

                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">
        {{ $brands->links() }}
    </div>

</x-card>

@endsection