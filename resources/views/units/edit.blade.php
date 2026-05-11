@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Unit
            </h1>

            <p class="text-gray-500 text-sm">
                Update unit details
            </p>

        </div>

        <a href="{{ route('units.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <x-card>

        <form
            action="{{ route('units.update', $unit->id) }}"
            method="POST"
            class="space-y-6"
        >

            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>

                <label class="block mb-2 font-medium">
                    Unit Name
                </label>

                <x-input
                    type="text"
                    name="name"
                    value="{{ old('name', $unit->name) }}"
                    placeholder="Enter unit name"
                />

                @error('name')

                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Short Name --}}
            <div>

                <label class="block mb-2 font-medium">
                    Short Name
                </label>

                <x-input
                    type="text"
                    name="short_name"
                    value="{{ old('short_name', $unit->short_name) }}"
                    placeholder="Example: KG, PCS, LTR"
                />

                @error('short_name')

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
                        {{ $unit->status ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ !$unit->status ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>

            <div>

                <x-button type="submit">
                    Update Unit
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection