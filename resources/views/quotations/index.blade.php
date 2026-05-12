@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tight">
            Quotations / Estimates
        </h1>
        <p class="text-gray-500 text-sm tracking-wide mt-1">Manage wholesale quotations and business estimates</p>
    </div>

    @can('create_quotations')
        <a href="{{ route('quotations.create') }}">
            <button class="px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
                + New Quotation
            </button>
        </a>
    @endcan
</div>

<x-card class="border-none shadow-xl shadow-gray-100 rounded-3xl">
    <x-table>
        <thead class="bg-gray-50/50">
            <tr class="text-left border-b border-gray-100">
                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Quotation No</th>
                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Customer</th>
                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Date</th>
                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Grand Total</th>
                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($quotations as $quotation)
                <tr class="hover:bg-gray-50/30 transition-all group">
                    <td class="px-8 py-5">
                        <span class="font-bold text-gray-800 text-sm tracking-tight">{{ $quotation->quotation_no }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-600">{{ $quotation->customer->name ?? 'Walk-in Customer' }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-600">{{ date('d M Y', strtotime($quotation->quotation_date)) }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-xs font-black text-indigo-600">₹{{ number_format($quotation->total, 2) }}</span>
                    </td>
                    <td class="px-8 py-5">
                        @if($quotation->status == 'pending')
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-yellow-100">Pending</span>
                        @elseif($quotation->status == 'approved')
                            <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-green-100">Approved</span>
                        @else
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-indigo-100">Converted</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-center">
                        <div x-data="{ openActionMenu: false, openDeleteModal: false, openConvertModal: false }" class="relative inline-block text-left">
                            <button @click="openActionMenu = !openActionMenu" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all border border-gray-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5h.01M12 12h.01M12 19h.01" /></svg>
                            </button>

                            <div x-show="openActionMenu" @click.away="openActionMenu = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[70] overflow-hidden origin-top-right" style="display: none;">
                                
                                @can('update_quotations')
                                    {{-- Approve --}}
                                    @if($quotation->status == 'pending')
                                        <form action="{{ route('quotations.approve', $quotation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full px-6 py-3.5 hover:bg-green-50/50 transition-all group text-left">
                                                <span class="font-bold text-gray-700 text-[11px] uppercase tracking-wider">Approve Quotation</span>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Convert to Sale --}}
                                    @if($quotation->status == 'approved')
                                        <button @click="openConvertModal = true; openActionMenu = false" class="w-full px-6 py-3.5 hover:bg-indigo-50/50 transition-all group text-left border-b border-gray-50">
                                            <span class="font-bold text-indigo-600 text-[11px] uppercase tracking-wider">Convert to Sale</span>
                                        </button>
                                    @endif
                                @endcan

                                <a href="{{ route('quotations.show', $quotation->id) }}" class="block px-6 py-3.5 hover:bg-gray-50 transition-all group">
                                    <span class="font-bold text-gray-700 text-[11px] uppercase tracking-wider">View Details</span>
                                </a>

                                @can('update_quotations')
                                    @if($quotation->status != 'converted')
                                        <a href="{{ route('quotations.edit', $quotation->id) }}" class="block px-6 py-3.5 hover:bg-indigo-50/50 transition-all group">
                                            <span class="font-bold text-gray-700 text-[11px] uppercase tracking-wider">Edit Quotation</span>
                                        </a>
                                    @endif
                                @endcan

                                @can('delete_quotations')
                                    <button @click="openDeleteModal = true; openActionMenu = false;" class="w-full px-6 py-3.5 hover:bg-red-50 text-red-500 transition-all group text-left border-t border-gray-50">
                                        <span class="font-bold text-[11px] uppercase tracking-wider">Delete Quotation</span>
                                    </button>
                                @endcan
                            </div>

                            {{-- Convert Modal --}}
                            <div x-show="openConvertModal" class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-[100]" style="display: none;">
                                <div @click.away="openConvertModal = false" x-transition class="bg-white rounded-[40px] shadow-2xl w-full max-w-md p-12 text-center">
                                    <div class="w-24 h-24 bg-indigo-50 rounded-[32px] flex items-center justify-center text-indigo-600 mx-auto mb-8 shadow-xl shadow-indigo-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                    <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tight mb-4 text-left">Convert to Sale?</h2>
                                    <p class="text-gray-500 text-sm mb-12 leading-relaxed text-left font-medium">This will generate a formal invoice and <span class="text-indigo-600 font-bold underline decoration-wavy underline-offset-4">automatically deduct stock</span> for all items. Are you ready to finalize this deal?</p>
                                    <div class="grid grid-cols-2 gap-6">
                                        <button @click="openConvertModal = false" class="px-8 py-5 bg-gray-50 text-gray-500 rounded-3xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-gray-100 transition-all">Not Yet</button>
                                        <form action="{{ route('quotations.convert', $quotation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full px-8 py-5 bg-indigo-600 text-white rounded-3xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-2xl shadow-indigo-200">Yes, Sell it!</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Delete Modal --}}
                            <div x-show="openDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-[100]" style="display: none;">
                                <div @click.away="openDeleteModal = false" x-transition class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-10 text-center">
                                    <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight mb-2">Are you sure?</h2>
                                    <p class="text-gray-500 text-sm mb-10 leading-relaxed font-medium">This action will permanently delete <span class="text-gray-800 font-bold">"{{ $quotation->quotation_no }}"</span> and cannot be undone.</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button @click="openDeleteModal = false" class="px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Cancel</button>
                                        <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST">
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
                    <td colspan="6" class="px-8 py-12 text-center text-gray-500">No Quotations Found</td>
                </tr>
            @endforelse
        </tbody>
    </x-table>
</x-card>

@endsection
