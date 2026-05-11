@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
            <p class="text-gray-500 text-sm">Update details for <strong>{{ $user->name }}</strong></p>
        </div>
        <a href="{{ route('users.index') }}"><x-button>← Back</x-button></a>
    </div>

    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <x-card>
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Avatar header --}}
            <div class="flex items-center gap-5 pb-4 border-b">
                <div>
                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            {{-- Name + Email --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                    <x-input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name" />
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <x-input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email address" />
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Phone + Role --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Phone Number</label>
                    <x-input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Enter phone number" />
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">— Choose Role —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ (old('role', $user->roles->first()?->name) == $role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Password --}}
            <div class="grid grid-cols-2 gap-6">
                <div x-data="{ show: false }">
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        New Password
                        <span class="text-gray-400 font-normal">(leave blank to keep current)</span>
                    </label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="Enter new password"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-10 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <button type="button" @click="show=!show" class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div x-data="{ show: false }">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Confirm New Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm new password"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-10 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <button type="button" @click="show=!show" class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="1" {{ old('status', $user->status ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $user->status ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <x-button type="submit">Update User</x-button>
                <a href="{{ route('users.index') }}">
                    <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-sm font-medium">Cancel</button>
                </a>
            </div>

        </form>
    </x-card>

</div>

@endsection
