@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Create Warehouse</h1>
    <a href="{{ route('warehouses.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-gray-300 transition">
        Back
    </a>
</div>

<x-card>
    <form action="{{ route('warehouses.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">Name:<span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Name" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">Email:<span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">Phone Number:<span class="text-red-500">*</span></label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter Phone Number" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none @error('phone_number') border-red-500 @enderror">
                @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">Country:<span class="text-red-500">*</span></label>
                <input type="text" name="country" value="{{ old('country') }}" placeholder="Enter Country" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none @error('country') border-red-500 @enderror">
                @error('country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">City:<span class="text-red-500">*</span></label>
                <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter City" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none @error('city') border-red-500 @enderror">
                @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">Zip Code:<span class="text-red-500">*</span></label>
                <input type="text" name="zip_code" value="{{ old('zip_code') }}" placeholder="Enter Zip Code" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 outline-none @error('zip_code') border-red-500 @enderror">
                @error('zip_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition">Save</button>
            <a href="{{ route('warehouses.index') }}" class="bg-gray-200 text-gray-700 px-8 py-2.5 rounded-xl font-bold hover:bg-gray-300 transition text-center">Cancel</a>
        </div>
    </form>
</x-card>
@endsection
