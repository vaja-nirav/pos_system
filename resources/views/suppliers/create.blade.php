@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Add Supplier
            </h1>

            <p class="text-gray-500 text-sm">
                Create new supplier
            </p>

        </div>

        <a href="{{ route('suppliers.index') }}">

            <x-button>
                Back
            </x-button>

        </a>

    </div>

    <x-card>

        <form
            action="{{ route('suppliers.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-2 gap-6"
        >

            @csrf

            <div>
                <label class="block mb-2 font-medium">Supplier Name</label>

                <x-input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Email</label>

                <x-input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Phone</label>

                <x-input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Company Name</label>

                <x-input
                    type="text"
                    name="company_name"
                    value="{{ old('company_name') }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">GST Number</label>

                <x-input
                    type="text"
                    name="gst_number"
                    value="{{ old('gst_number') }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Supplier Image</label>

                <x-input
                    type="file"
                    name="image"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">City</label>

                <x-input
                    type="text"
                    name="city"
                    value="{{ old('city') }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">State</label>

                <x-input
                    type="text"
                    name="state"
                    value="{{ old('state') }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Zip Code</label>

                <x-input
                    type="text"
                    name="zip_code"
                    value="{{ old('zip_code') }}"
                />
            </div>

            <div class="col-span-2">
                <label class="block mb-2 font-medium">Address</label>

                <textarea
                    name="address"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >{{ old('address') }}</textarea>
            </div>

            <div class="col-span-2">

                <label class="block mb-2 font-medium">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

                    <option value="1">Active</option>

                    <option value="0">Inactive</option>

                </select>

            </div>

            <div class="col-span-2">

                <x-button type="submit">
                    Save Supplier
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection