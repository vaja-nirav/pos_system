@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            Units
        </h1>

        <p class="text-gray-500 text-sm">
            Manage all units
        </p>

    </div>

    @can('create_units')
    <a href="{{ route('units.create') }}">

        <x-button>
            + Add Unit
        </x-button>

    </a>
    @endcan

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
                    Short Name
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

            @forelse($units as $unit)

                <tr class="border-t">

                    <td class="p-4">
                        {{ $unit->id }}
                    </td>

                    <td class="p-4">
                        {{ $unit->name }}
                    </td>

                    <td class="p-4">
                        {{ $unit->short_name }}
                    </td>

                    <td class="p-4">

                        @if($unit->status)

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

                            @can('update_units')
                            <a href="{{ route('units.edit', $unit->id) }}">

                                <x-button>
                                    Edit
                                </x-button>

                            </a>
                            @endcan

                            @can('delete_units')
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
                                            Delete Unit
                                        </h2>

                                        <p class="text-gray-500 mb-6">
                                            Are you sure you want to delete this unit?
                                        </p>

                                        <div class="flex justify-end gap-3">

                                            <button
                                                @click="openDeleteModal = false"
                                                class="px-4 py-2 border rounded-lg"
                                            >
                                                Cancel
                                            </button>

                                            <form
                                                action="{{ route('units.destroy', $unit->id) }}"
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
                            @endcan

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No Units Found
                    </td>

                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">
        {{ $units->links() }}
    </div>

</x-card>

@endsection