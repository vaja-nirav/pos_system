@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Users</h1>
        <p class="text-gray-500 text-sm">Manage system users and roles</p>
    </div>

    @can('create_users')
    <a href="{{ route('users.create') }}">
        <x-button>+ Add User</x-button>
    </a>
    @endcan

</div>

<x-card>

    <x-table>

        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">#</th>
                <th class="p-4 text-left">Name</th>
                <th class="p-4 text-left">Email</th>
                <th class="p-4 text-left">Phone</th>
                <th class="p-4 text-left">Role</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-center">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($users as $user)

                <tr class="border-t hover:bg-gray-50 transition">

                    <td class="p-4 text-gray-500">
                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                    </td>

                    {{-- Name + Avatar --}}
                    <td class="p-4">
                        <div class="flex items-center gap-3">

                            <div>
                                <div class="font-semibold text-gray-800">{{ $user->name }}</div>
                            </div>

                        </div>
                    </td>

                    <td class="p-4 text-gray-600">{{ $user->email }}</td>

                    <td class="p-4 text-gray-600">{{ $user->phone ?? '—' }}</td>

                    {{-- Role --}}
                    <td class="p-4">
                        @forelse($user->roles as $role)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="text-gray-400 text-sm">No Role</span>
                        @endforelse
                    </td>

                    {{-- Status --}}
                    <td class="p-4">
                        @if($user->status)
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                Active
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-500 rounded-full text-xs font-medium">
                                Inactive
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="p-4 text-center">

                        <div
                            x-data="{ openMenu: false, openDeleteModal: false }"
                            class="relative inline-block text-left"
                        >

                            <button
                                @click="openMenu = !openMenu"
                                class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 5h.01M12 12h.01M12 19h.01"/>
                                </svg>
                            </button>

                            <div
                                x-show="openMenu"
                                @click.away="openMenu = false"
                                x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border z-50 overflow-hidden"
                                style="display: none;"
                            >
                                @can('update_users')
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    <span class="font-medium text-gray-700">Edit</span>
                                </a>
                                @endcan

                                @if($user->id !== auth()->id())
                                    @can('delete_users')
                                        <button
                                            @click="openDeleteModal = true; openMenu = false"
                                            class="w-full flex items-center gap-3 px-5 py-3 hover:bg-red-50 text-red-500 transition text-left"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span class="font-medium">Delete</span>
                                        </button>
                                    @endcan
                                @endif
                            </div>

                            {{-- Delete Modal --}}
                            <div
                                x-show="openDeleteModal"
                                class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
                                style="display: none;"
                            >
                                <div
                                    @click.away="openDeleteModal = false"
                                    class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6"
                                >
                                    <h2 class="text-xl font-bold text-gray-800 mb-3">Delete User</h2>
                                    <p class="text-gray-500 mb-6">
                                        Are you sure you want to delete
                                        <strong>{{ $user->name }}</strong>?
                                        This action cannot be undone.
                                    </p>
                                    <div class="flex justify-end gap-3">
                                        <button @click="openDeleteModal = false"
                                                class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                                            Cancel
                                        </button>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        No users found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">
        {{ $users->links() }}
    </div>

</x-card>

@endsection
