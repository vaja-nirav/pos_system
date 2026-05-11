@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Expenses
            </h1>

            <p class="text-gray-500">
                Manage all business expenses
            </p>

        </div>

        <a href="{{ route('expenses.create') }}">

            <x-button>
                + Create Expense
            </x-button>

        </a>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 overflow-visible">

        <div class=" overflow-visible">

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="pb-4 text-left">
                            Title
                        </th>

                        <th class="pb-4 text-left">
                            Category
                        </th>

                        <th class="pb-4 text-left">
                            Amount
                        </th>

                        <th class="pb-4 text-left">
                            Date
                        </th>

                        <th class="pb-4 text-left">
                            Status
                        </th>

                        <th class="pb-4 text-right">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($expenses as $expense)

                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- Title --}}
                            <td class="py-4 font-medium">

                                {{ $expense->title }}

                            </td>

                            {{-- Category --}}
                            <td class="py-4">

                                <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">

                                    {{ $expense->category->name }}

                                </span>

                            </td>

                            {{-- Amount --}}
                            <td class="py-4 font-bold text-red-500">

                                ₹{{ number_format($expense->amount, 2) }}

                            </td>

                            {{-- Date --}}
                            <td class="py-4">

                                {{ date('d M Y', strtotime($expense->expense_date)) }}

                            </td>

                            {{-- Status --}}
                            <td class="py-4">

                                @if($expense->status)

                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">

                                        Active

                                    </span>

                                @else

                                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            {{-- Actions --}}
                            <td class="py-4 text-right">

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
                                        class="absolute right-0 top-12 w-56 bg-white rounded-2xl shadow-2xl border z-[9999] overflow-hidden"
                                        style="display: none;"
                                    >

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('expenses.edit', $expense->id) }}"
                                            class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition"
                                        >

                                            <span>
                                                Edit Expense
                                            </span>

                                        </a>

                                        {{-- Delete --}}
                                        <button
                                            @click="
                                                openDeleteModal = true;
                                                openActionMenu = false;
                                            "
                                            class="w-full flex items-center gap-3 px-5 py-3 hover:bg-red-50 text-red-500 transition text-left"
                                        >

                                            <span>
                                                Delete Expense
                                            </span>

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

                                            <h2 class="text-xl font-bold mb-3">
                                                Delete Expense
                                            </h2>

                                            <p class="text-gray-500 mb-6">

                                                Are you sure you want to delete this expense?

                                            </p>

                                            <div class="flex justify-end gap-3">

                                                <button
                                                    @click="openDeleteModal = false"
                                                    class="px-4 py-2 border rounded-lg"
                                                >
                                                    Cancel
                                                </button>

                                                <form
                                                    action="{{ route('expenses.destroy', $expense->id) }}"
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

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="py-6 text-center text-gray-500"
                            >

                                No Expenses Found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="mt-6">

            {{ $expenses->links() }}

        </div>

    </div>

</div>

@endsection