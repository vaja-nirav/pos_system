@extends('layouts.app')
@section('content')
<div x-data="{ openDeleteModal: false, deleteUrl: '', storeName: '' }" class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Store Management</h1>
            <p class="text-gray-500 mt-1">Monitor and manage multi-store operations and performance.</p>
        </div>
        @can('create_stores')
        <a href="{{ route('stores.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add New Store
        </a>
        @endcan
    </div>

    {{-- Stores Table --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Store Details</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Contact</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($stores as $store)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $store->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-mono">{{ $store->code ?? 'NO-CODE' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $store->email ?? 'No Email' }}</p>
                            <p class="text-xs text-gray-400">{{ $store->phone ?? 'No Phone' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($store->status)
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-full uppercase">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                @can('update_stores')
                                <a href="{{ route('stores.edit', $store->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                @endcan

                                @can('delete_stores')
                                    @if($store->name !== 'Local Store')
                                    <button 
                                        @click="openDeleteModal = true; deleteUrl = '{{ route('stores.destroy', $store->id) }}'; storeName = '{{ $store->name }}'"
                                        class="p-2 text-gray-400 hover:text-red-600 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div
        x-show="openDeleteModal"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            @click.away="openDeleteModal = false"
            class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md p-8 overflow-hidden relative"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        >
            <div class="text-center">
                <h2 class="text-2xl font-black text-gray-900 mb-2">Delete Store?</h2>
                <p class="text-gray-500 mb-8">
                    Are you sure you want to delete <span class="font-bold text-gray-800" x-text="storeName"></span>? This action will remove all associated data and cannot be undone.
                </p>
                <div class="flex gap-3">
                    <button 
                        @click="openDeleteModal = false"
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all"
                    >
                        Cancel
                    </button>
                    <form :action="deleteUrl" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-2xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-200">
                            Delete Store
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

