@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Customer
            </h1>

            <p class="text-gray-500 text-sm">
                Update customer details
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
            action="{{ route('customers.update', $customer->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-2 gap-6"
        >

            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>

                <label class="block mb-2 font-medium">
                    Customer Name
                </label>

                <x-input
                    type="text"
                    name="name"
                    value="{{ old('name', $customer->name) }}"
                />

            </div>

            {{-- Email --}}
            <div>

                <label class="block mb-2 font-medium">
                    Email
                </label>

                <x-input
                    type="email"
                    name="email"
                    value="{{ old('email', $customer->email) }}"
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
                    value="{{ old('phone', $customer->phone) }}"
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

                    <option
                        value="regular"
                        {{ $customer->customer_type == 'regular' ? 'selected' : '' }}
                    >
                        Regular
                    </option>

                    <option
                        value="wholesale"
                        {{ $customer->customer_type == 'wholesale' ? 'selected' : '' }}
                    >
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
                    value="{{ old('city', $customer->city) }}"
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
                    value="{{ old('state', $customer->state) }}"
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
                    value="{{ old('zip_code', $customer->zip_code) }}"
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

            {{-- Current Image --}}
            @if($customer->getFirstMediaUrl('customers'))

                <div class="col-span-2">

                    <label class="block mb-2 font-medium">
                        Current Image
                    </label>

                    <img
                        src="{{ $customer->getFirstMediaUrl('customers') }}"
                        class="w-24 h-24 rounded-lg object-cover"
                    >

                </div>

            @endif

            {{-- Address --}}
            <div class="col-span-2">

                <label class="block mb-2 font-medium">
                    Address
                </label>

                <textarea
                    name="address"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >{{ old('address', $customer->address) }}</textarea>

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

                    <option
                        value="1"
                        {{ $customer->status ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ !$customer->status ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>

            <div class="col-span-2">

                <x-button type="submit">
                    Update Customer
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection