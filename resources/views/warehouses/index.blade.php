@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Warehouses</h1>
    @can('create_warehouses')
    <a href="{{ route('warehouses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-indigo-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Create Warehouse
    </a>
    @endcan
</div>

<x-card>
    <x-table>
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left uppercase text-[11px] font-bold text-gray-500">Name</th>
                <th class="p-4 text-left uppercase text-[11px] font-bold text-gray-500">Email</th>
                <th class="p-4 text-left uppercase text-[11px] font-bold text-gray-500">Phone</th>
                <th class="p-4 text-left uppercase text-[11px] font-bold text-gray-500">Location</th>
                <th class="p-4 text-left uppercase text-[11px] font-bold text-gray-500">Status</th>
                <th class="p-4 text-right uppercase text-[11px] font-bold text-gray-500">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-50">
            @forelse($warehouses as $warehouse)
            <tr>
                <td class="p-4 font-bold text-gray-800">{{ $warehouse->name }}</td>
                <td class="p-4 text-gray-600">{{ $warehouse->email }}</td>
                <td class="p-4 text-gray-600">{{ $warehouse->phone_number }}</td>
                <td class="p-4 text-gray-600">{{ $warehouse->city }}, {{ $warehouse->country }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $warehouse->status ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        {{ $warehouse->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-4">
                    <div class="flex justify-end gap-2">
                        @can('update_warehouses')
                        <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        @endcan
                        @can('delete_warehouses')
                        <div x-data="{ openDeleteModal: false }">
                            <button 
                                @click="openDeleteModal = true"
                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>

                            <div 
                                x-show="openDeleteModal" 
                                class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50"
                                x-cloak
                            >
                                <div @click.away="openDeleteModal = false" class="bg-white rounded-2xl p-8 max-w-sm w-full shadow-2xl transform transition-all">
                                    <div class="text-center">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Delete</h3>
                                        <p class="text-gray-500 mb-6">Are you sure you want to delete <span class="font-bold text-gray-700">{{ $warehouse->name }}</span>? This action cannot be undone.</p>
                                        
                                        <div class="flex gap-3">
                                            <button @click="openDeleteModal = false" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition">Cancel</button>
                                            <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition">Delete</button>
                                            </form>
                                        </div>
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
                <td colspan="6" class="text-center text-gray-500 py-10 italic">No warehouses found</td>
            </tr>
            @endforelse
        </tbody>
    </x-table>
</x-card>
@endsection
