@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Brand
            </h1>

            <p class="text-gray-500 text-sm">
                Update brand details
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
            action="{{ route('brands.update', $brand->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >

            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>

                <label class="block mb-2 font-medium">
                    Brand Name
                </label>

                <x-input
                    type="text"
                    name="name"
                    value="{{ old('name', $brand->name) }}"
                    placeholder="Enter brand name"
                />

                @error('name')

                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Current Image --}}
             @if($brand->getFirstMediaUrl('brands'))

                <div>

                    <label class="block mb-2 font-medium">
                        Current Image
                    </label>

                    <img
                        src="{{ $brand->getFirstMediaUrl('brands') }}"
                        class="w-24 h-24 rounded-lg object-cover"
                        alt="{{ $brand->name }}"
                    >

                </div>

            @endif

            {{-- New Image --}}
            <div>

                <label class="block mb-2 font-medium">
                    New Image
                </label>

                <x-input
                    type="file"
                    name="image"
                />

                @error('image')

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
                        {{ $brand->status ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ !$brand->status ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>

            <div>

                <x-button type="submit">
                    Update Brand
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection