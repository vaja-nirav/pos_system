@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Role</h1>
            <p class="text-gray-500 text-sm">Update permissions for <strong>{{ $role->name }}</strong></p>
        </div>
        <a href="{{ route('roles.index') }}">
            <x-button>← Back</x-button>
        </a>
    </div>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-card class="mb-6">
            <div class="max-w-md">
                <label class="block mb-2 text-sm font-medium text-gray-700">Role Name <span class="text-red-500">*</span></label>
                <x-input type="text" name="name" value="{{ old('name', $role->name) }}" {{ $role->name === 'admin' ? 'readonly' : '' }} required />
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </x-card>

        <x-card>
            <div class="flex items-center justify-between mb-4 pb-4 border-b">
                <h3 class="font-bold text-gray-800">Permissions</h3>
                <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-gray-600">
                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    All Permissions
                </label>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Module</th>
                            <th class="px-4 py-3 text-center">View</th>
                            <th class="px-4 py-3 text-center">Create</th>
                            <th class="px-4 py-3 text-center">Update</th>
                            <th class="px-4 py-3 text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($groupedPermissions as $module => $actions)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 font-semibold text-gray-800 capitalize">
                                    {{ str_replace('_', ' ', $module) }}
                                </td>
                                
                                @php
                                    $possibleActions = ['view', 'create', 'update', 'delete'];
                                @endphp

                                @foreach($possibleActions as $action)
                                    <td class="px-4 py-4 text-center">
                                        @if(isset($actions[$action]))
                                            <input 
                                                type="checkbox" 
                                                name="permissions[]" 
                                                value="{{ $actions[$action]->name }}"
                                                class="permission-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                {{ in_array($actions[$action]->name, $rolePermissions) ? 'checked' : '' }}
                                            >
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex gap-3 mt-8">
                <x-button type="submit" class="px-10">Update Role</x-button>
                <a href="{{ route('roles.index') }}">
                    <button type="button" class="px-8 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-sm font-medium">Cancel</button>
                </a>
            </div>
        </x-card>
    </form>
</div>

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Also update Select All state when individual checkboxes change
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    function updateSelectAll() {
        const allChecked = Array.from(checkboxes).every(c => c.checked);
        document.getElementById('selectAll').checked = allChecked;
    }
    
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectAll);
    });
    
    // Initial check
    updateSelectAll();
</script>

@endsection
