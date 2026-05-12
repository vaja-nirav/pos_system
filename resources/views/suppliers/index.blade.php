@extends('layouts.app')

@section('content')

<div x-data="{ showImportModal: false, showFilter: false }">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tight">
                Suppliers
            </h1>
            <p class="text-gray-500 text-sm tracking-wide mt-1">Manage and track your supply chain partners</p>
        </div>

        <div class="flex items-center gap-3 relative">
            {{-- Filter/Export/Import Trigger --}}
            <button 
                @click="showFilter = !showFilter"
                class="w-12 h-12 flex items-center justify-center bg-white border border-gray-100 text-gray-400 rounded-2xl hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
            </button>

            {{-- Filter Dropdown --}}
            @can('create_suppliers')
                <div 
                    x-show="showFilter" 
                    @click.away="showFilter = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 top-16 w-80 bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 z-50 p-6 space-y-3"
                    style="display: none;"
                >
                    <a href="{{ route('suppliers.export') }}" class="w-full py-3 bg-indigo-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-100">
                        Export Suppliers (Excel)
                    </a>
                    <button @click="showImportModal = true; showFilter = false" class="w-full py-3 bg-white border border-gray-100 text-gray-700 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center hover:bg-gray-50 transition-all">
                        Import Suppliers
                    </button>
                </div>
            @endcan

            @can('create_suppliers')
                <a href="{{ route('suppliers.create') }}">
                    <button class="px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
                        + Create Supplier
                    </button>
                </a>
            @endcan
        </div>
    </div>

    <x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl">
        <x-table>
            <thead class="bg-gray-50/50">
                <tr class="text-left border-b border-gray-100">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Image</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Supplier</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Company</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Phone</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50/30 transition-all group">
                        <td class="px-8 py-5">
                            @if($supplier->getFirstMediaUrl('suppliers'))
                                <img src="{{ $supplier->getFirstMediaUrl('suppliers') }}" class="w-14 h-14 rounded-2xl object-cover shadow-sm border border-gray-100 group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-gray-100 border border-gray-50 flex items-center justify-center text-gray-300 text-xs font-black">
                                    {{ substr($supplier->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800 text-sm tracking-tight">{{ $supplier->name }}</span>
                                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-0.5">{{ $supplier->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-gray-600">{{ $supplier->company_name ?? '-' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-gray-600">{{ $supplier->phone }}</span>
                        </td>
                        <td class="px-8 py-5">
                            @if($supplier->status)
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-green-600 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Active
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-red-500 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div x-data="{ openActionMenu: false, openDeleteModal: false }" class="relative inline-block text-left">
                                <button @click="openActionMenu = !openActionMenu" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all border border-gray-100 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5h.01M12 12h.01M12 19h.01" /></svg>
                                </button>

                                <div x-show="openActionMenu" @click.away="openActionMenu = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[70] overflow-hidden origin-top-right" style="display: none;">
                                    @can('update_suppliers')
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="flex items-center gap-3 px-6 py-4">
                                            <span class="font-bold text-gray-700 text-xs">Edit Supplier</span>
                                        </a>
                                    @endcan
                                    @can('delete_suppliers')
                                        <button @click="openDeleteModal = true; openActionMenu = false;" class="w-full flex items-center gap-3 px-6 py-4 text-red-500 transition-all group text-left border-t border-gray-50">
                                            <span class="font-bold text-xs">Delete Supplier</span>
                                        </button>
                                    @endcan
                                </div>

                                {{-- Delete Modal --}}
                                <div x-show="openDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-[100]" style="display: none;">
                                    <div @click.away="openDeleteModal = false" x-transition class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-10 text-center">
                                        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center text-red-500 mx-auto mb-6"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></div>
                                        <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight mb-2">Are you sure?</h2>
                                        <p class="text-gray-500 text-sm mb-10 leading-relaxed font-medium">This action will permanently delete <span class="text-gray-800 font-bold">"{{ $supplier->name }}"</span> and cannot be undone.</p>
                                        <div class="grid grid-cols-2 gap-4">
                                            <button @click="openDeleteModal = false" class="px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Cancel</button>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-full px-8 py-4 bg-red-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-600 transition-all shadow-xl shadow-red-100">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                <span class="text-xs font-black uppercase tracking-widest">No suppliers found</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
        <div class="px-8 py-6 border-t border-gray-50">
            {{ $suppliers->links() }}
        </div>
    </x-card>

    {{-- Import Modal --}}
    <div 
        x-show="showImportModal" 
        class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-[100] p-4"
        style="display: none;"
    >
        <div 
            @click.away="showImportModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-10"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="bg-white rounded-[40px] shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]"
        >
            {{-- Modal Header --}}
            <div class="p-10 pb-6 flex items-center justify-between border-b border-gray-50">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tight">Import Suppliers</h2>
                    <p class="text-gray-500 text-sm mt-1">Bulk upload your suppliers using Excel or CSV</p>
                </div>
                <button @click="showImportModal = false" class="w-12 h-12 flex items-center justify-center bg-gray-50 text-gray-400 rounded-2xl hover:bg-red-50 hover:text-red-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="p-10 overflow-y-auto custom-scrollbar">
                <form action="{{ route('suppliers.import') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    {{-- Upload Area --}}
                    <div class="relative group">
                        <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-gray-200 rounded-[32px] p-12 text-center group-hover:border-indigo-500 group-hover:bg-indigo-50/30 transition-all">
                            <div class="w-20 h-20 bg-indigo-50 rounded-3xl flex items-center justify-center text-indigo-500 mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                            </div>
                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight mb-2">Drop your file here</h3>
                            <p class="text-gray-400 text-sm font-medium">Supports .xlsx, .xls, .csv</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="flex-1 py-5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
                            Save Suppliers
                        </button>
                        <a href="{{ route('suppliers.sample') }}" class="flex-1 py-5 bg-gray-50 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-100 transition-all text-center border border-gray-100">
                            Download Sample
                        </a>
                    </div>
                </form>

                {{-- Instructions --}}
                <div class="mt-12 space-y-6">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Field Guide</h4>
                    @php
                        $fields = [
                            'Name' => ['required' => true, 'desc' => 'Full name of the supplier'],
                            'Phone' => ['required' => true, 'desc' => 'Unique contact number'],
                            'Email' => ['required' => false, 'desc' => 'Contact email address'],
                            'Company' => ['required' => false, 'desc' => 'Company name'],
                            'Tax Number' => ['required' => false, 'desc' => 'VAT/GST number'],
                            'Status' => ['required' => false, 'desc' => 'Active or Inactive'],
                        ];
                    @endphp

                    <div class="bg-gray-50/50 border border-gray-100 rounded-3xl overflow-hidden">
                        @foreach($fields as $label => $data)
                            <div class="flex items-center justify-between px-6 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <span class="text-xs font-bold text-gray-700">{{ $label }}</span>
                                <div class="flex items-center gap-3">
                                    @if($data['required'])
                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-500 rounded-lg text-[10px] font-medium uppercase tracking-tighter">Required</span>
                                    @else
                                        <span class="px-3 py-1 bg-green-50 text-green-500 rounded-lg text-[10px] font-medium uppercase tracking-tighter">Optional</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection