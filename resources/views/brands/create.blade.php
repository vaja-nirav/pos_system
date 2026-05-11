@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Add Brand
            </h1>

            <p class="text-gray-500 text-sm">
                Create new brand
            </p>

        </div>

        <a href="{{ route('brands.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <x-card>

        <form
            action="{{ route('brands.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >

            @csrf

            {{-- Name --}}
            <div>

                <label class="block mb-2 font-medium">
                    Brand Name
                </label>

                <x-input
                    type="text"
                    name="name"
                    placeholder="Enter brand name"
                />

            </div>

            {{-- Image --}}
            <div>

                <label class="block mb-2 font-medium">
                    Brand Image
                </label>

                <x-input
                    type="file"
                    name="image"
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

            <div>

                <x-button type="submit">
                    Save Brand
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection