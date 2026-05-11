@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Roles & Permissions</h1>
        <p class="text-gray-500 text-sm">Manage system roles and their access levels</p>
    </div>
    <a href="{{ route('roles.create') }}">
        <x-button>+ Create Role</x-button>
    </a>
</div>

<x-card>
    <x-table>
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">#</th>
                <th class="p-4 text-left">Role Name</th>
                <th class="p-4 text-left">Permissions Count</th>
                <th class="p-4 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-4 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="p-4 font-semibold text-gray-800">{{ ucfirst($role->name) }}</td>
                    <td class="p-4 text-gray-600">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
                            {{ $role->permissions->count() }} Permissions
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('roles.edit', $role->id) }}" class="p-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            @if($role->name !== 'admin')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">No roles found.</td>
                </tr>
            @endforelse
        </tbody>
    </x-table>
    <div class="mt-5">
        {{ $roles->links() }}
    </div>
</x-card>

@endsection
