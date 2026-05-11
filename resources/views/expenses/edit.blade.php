@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Edit Expense
            </h1>

            <p class="text-gray-500">
                Update business expense
            </p>

        </div>

        <a href="{{ route('expenses.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    {{-- Form --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <form
            action="{{ route('expenses.update', $expense->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">

                {{-- Category --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Expense Category
                    </label>

                    <select
                        name="expense_category_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                        <option value="">
                            Select Category
                        </option>

                        @foreach($expenseCategories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('expense_category_id', $expense->expense_category_id) == $category->id ? 'selected' : '' }}
                            >

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('expense_category_id')

                        <p class="text-red-500 text-sm mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Title --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Expense Title
                    </label>

                    <x-input
                        type="text"
                        name="title"
                        value="{{ old('title', $expense->title) }}"
                        placeholder="Enter expense title"
                    />

                    @error('title')

                        <p class="text-red-500 text-sm mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Amount --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Amount
                    </label>

                    <x-input
                        type="number"
                        step="0.01"
                        name="amount"
                        value="{{ old('amount', $expense->amount) }}"
                    />

                    @error('amount')

                        <p class="text-red-500 text-sm mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Expense Date --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Expense Date
                    </label>

                    <x-input
                        type="date"
                        name="expense_date"
                        value="{{ old('expense_date', $expense->expense_date) }}"
                    />

                    @error('expense_date')

                        <p class="text-red-500 text-sm mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Status --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >

                        <option
                            value="1"
                            {{ old('status', $expense->status) == 1 ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="0"
                            {{ old('status', $expense->status) == 0 ? 'selected' : '' }}
                        >
                            Inactive
                        </option>

                    </select>

                    @error('status')

                        <p class="text-red-500 text-sm mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

            </div>

            {{-- Note --}}
            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Note
                </label>

                <textarea
                    name="note"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    placeholder="Write expense note..."
                >{{ old('note', $expense->note) }}</textarea>

                @error('note')

                    <p class="text-red-500 text-sm mt-1">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Submit --}}
            <div class="mt-6 flex items-center gap-3">

                <x-button>
                    Update Expense
                </x-button>

                <a
                    href="{{ route('expenses.index') }}"
                    class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection