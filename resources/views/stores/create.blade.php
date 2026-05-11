@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Create Store</h1>
        <p class="text-gray-500 mt-1">Register a new retail location.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
        <form action="{{ route('stores.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Store Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 transition-all font-medium" placeholder="e.g. Spain - Local Store">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Store Code</label>
                    <input type="text" name="code" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 transition-all font-medium" placeholder="e.g. STORE-001">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Status</label>
                    <select name="status" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 transition-all font-medium" placeholder="store@example.com">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Phone</label>
                    <input type="text" name="phone" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 transition-all font-medium" placeholder="+1 234 567 890">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex gap-4">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">Save Store</button>
                <a href="{{ route('stores.index') }}" class="px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-black uppercase tracking-widest hover:bg-gray-200 transition-all text-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
