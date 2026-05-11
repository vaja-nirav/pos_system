@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Create Expense
            </h1>

            <p class="text-gray-500">
                Add new business expense
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
            action="{{ route('expenses.store') }}"
            method="POST"
        >

            @csrf

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

                            <option value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Title --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Expense Title
                    </label>

                    <x-input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Enter expense title"
                    />

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
                        value="{{ old('amount') }}"
                    />

                </div>

                {{-- Expense Date --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Expense Date
                    </label>

                    <x-input
                        type="date"
                        name="expense_date"
                        value="{{ date('Y-m-d') }}"
                    />

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

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
                            Inactive
                        </option>

                    </select>

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
                >{{ old('note') }}</textarea>

            </div>

            {{-- Submit --}}
            <div class="mt-6">

                <x-button>
                    Save Expense
                </x-button>

            </div>

        </form>

    </div>

</div>

@endsection