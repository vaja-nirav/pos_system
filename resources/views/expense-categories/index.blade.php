@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Expense Categories
            </h1>

        </div>

        <a href="{{ route('expense-categories.create') }}">

            <x-button>
                + Create Expense Category
            </x-button>

        </a>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="pb-4 text-left">
                            Name
                        </th>

                        <th class="pb-4 text-center">
                            Status
                        </th>

                        <th class="pb-4 text-right">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($expenseCategories as $expenseCategory)

                        <tr class="border-b">

                            {{-- Name --}}
                            <td class="py-4 font-medium">

                                {{ $expenseCategory->name }}

                            </td>

                            {{-- Status --}}
                            <td class="py-4 text-center">

                                @if($expenseCategory->status)

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
                            <td class="py-4">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('expense-categories.edit', $expenseCategory->id) }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-lg"
                                    >
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('expense-categories.destroy', $expenseCategory->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this expense category?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="py-6 text-center text-gray-500"
                            >

                                No Expense Categories Found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="mt-6">

            {{ $expenseCategories->links() }}

        </div>

    </div>

</div>

@endsection