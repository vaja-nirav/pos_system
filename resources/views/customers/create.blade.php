@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Add Customer
            </h1>

            <p class="text-gray-500 text-sm">
                Create new customer
            </p>

        </div>

        <a href="{{ route('customers.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <x-card>

        <form
            action="{{ route('customers.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-2 gap-6"
        >

            @csrf

            {{-- Name --}}
            <div>

                <label class="block mb-2 font-medium">
                    Customer Name
                </label>

                <x-input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter customer name"
                />

                @error('name')

                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Email --}}
            <div>

                <label class="block mb-2 font-medium">
                    Email
                </label>

                <x-input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter email"
                />

            </div>

            {{-- Phone --}}
            <div>

                <label class="block mb-2 font-medium">
                    Phone
                </label>

                <x-input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Enter phone number"
                />

            </div>

            {{-- Customer Type --}}
            <div>

                <label class="block mb-2 font-medium">
                    Customer Type
                </label>

                <select
                    name="customer_type"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    <option value="regular">
                        Regular
                    </option>

                    <option value="wholesale">
                        Wholesale
                    </option>

                </select>

            </div>

            {{-- City --}}
            <div>

                <label class="block mb-2 font-medium">
                    City
                </label>

                <x-input
                    type="text"
                    name="city"
                    value="{{ old('city') }}"
                    placeholder="Enter city"
                />

            </div>

            {{-- State --}}
            <div>

                <label class="block mb-2 font-medium">
                    State
                </label>

                <x-input
                    type="text"
                    name="state"
                    value="{{ old('state') }}"
                    placeholder="Enter state"
                />

            </div>

            {{-- Zip Code --}}
            <div>

                <label class="block mb-2 font-medium">
                    Zip Code
                </label>

                <x-input
                    type="text"
                    name="zip_code"
                    value="{{ old('zip_code') }}"
                    placeholder="Enter zip code"
                />

            </div>

            {{-- Customer Image --}}
            <div>

                <label class="block mb-2 font-medium">
                    Customer Image
                </label>

                <x-input
                    type="file"
                    name="image"
                />

            </div>

            {{-- Address --}}
            <div class="col-span-2">

                <label class="block mb-2 font-medium">
                    Address
                </label>

                <textarea
                    name="address"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >{{ old('address') }}</textarea>

            </div>

            {{-- Status --}}
            <div class="col-span-2">

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

            <div class="col-span-2">

                <x-button type="submit">
                    Save Customer
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection