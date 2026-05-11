@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Supplier
            </h1>

            <p class="text-gray-500 text-sm">
                Update supplier details
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
            action="{{ route('suppliers.update', $supplier->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-2 gap-6"
        >

            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-medium">Supplier Name</label>

                <x-input
                    type="text"
                    name="name"
                    value="{{ old('name', $supplier->name) }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Email</label>

                <x-input
                    type="email"
                    name="email"
                    value="{{ old('email', $supplier->email) }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Phone</label>

                <x-input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $supplier->phone) }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Company Name</label>

                <x-input
                    type="text"
                    name="company_name"
                    value="{{ old('company_name', $supplier->company_name) }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">GST Number</label>

                <x-input
                    type="text"
                    name="gst_number"
                    value="{{ old('gst_number', $supplier->gst_number) }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Supplier Image</label>

                <x-input
                    type="file"
                    name="image"
                />
            </div>

            @if($supplier->getFirstMediaUrl('suppliers'))

                <div class="col-span-2">

                    <label class="block mb-2 font-medium">
                        Current Image
                    </label>

                    <img
                        src="{{ $supplier->getFirstMediaUrl('suppliers') }}"
                        class="w-24 h-24 rounded-lg object-cover"
                    >

                </div>

            @endif

            <div>
                <label class="block mb-2 font-medium">City</label>

                <x-input
                    type="text"
                    name="city"
                    value="{{ old('city', $supplier->city) }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">State</label>

                <x-input
                    type="text"
                    name="state"
                    value="{{ old('state', $supplier->state) }}"
                />
            </div>

            <div>
                <label class="block mb-2 font-medium">Zip Code</label>

                <x-input
                    type="text"
                    name="zip_code"
                    value="{{ old('zip_code', $supplier->zip_code) }}"
                />
            </div>

            <div class="col-span-2">
                <label class="block mb-2 font-medium">Address</label>

                <textarea
                    name="address"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >{{ old('address', $supplier->address) }}</textarea>
            </div>

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
                        {{ $supplier->status ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ !$supplier->status ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>

            <div class="col-span-2">

                <x-button type="submit">
                    Update Supplier
                </x-button>

            </div>

        </form>

    </x-card>

</div>

@endsection