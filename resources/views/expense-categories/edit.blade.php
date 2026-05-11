@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Edit Expense Category
            </h1>

        </div>

        <a href="{{ route('expense-categories.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    {{-- Form --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <form
            action="{{ route('expense-categories.update', $expenseCategory->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">

                {{-- Name --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Category Name
                    </label>

                    <x-input
                        type="text"
                        name="name"
                        value="{{ old('name', $expenseCategory->name) }}"
                    />

                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                            {{ $expenseCategory->status == 1 ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="0"
                            {{ $expenseCategory->status == 0 ? 'selected' : '' }}
                        >
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

            {{-- Submit --}}
            <div class="mt-6">

                <x-button>
                    Update Expense Category
                </x-button>

            </div>

        </form>

    </div>

</div>

@endsection