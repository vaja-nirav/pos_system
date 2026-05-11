@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- ════════════════════════════════════════════════
         CREATE VARIATION MODAL (Multiple Values)
    ════════════════════════════════════════════════ --}}
    <div class="fixed inset-0 bg-black/45 backdrop-blur-sm flex items-center justify-center z-[9999] opacity-0 pointer-events-none transition-opacity duration-200 ease" id="createModal">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-2xl transform transition-all duration-200 ease scale-95" id="createModalBox">
            <div class="flex items-start justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-800">Create Variation</h3>
                <button class="text-gray-400 hover:text-gray-600 text-2xl leading-none" onclick="closeModal('createModal')">&times;</button>
            </div>

            <form action="{{ route('variations.store') }}" method="POST" id="createVariationForm">
                @csrf

                {{-- Variation Name --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Name:<span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Enter Name" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Variation Types (Dynamic List) --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Variation Types:<span class="text-red-500">*</span></label>
                    <div id="variationValuesContainer" class="space-y-2.5">
                        <div class="flex items-center gap-2 value-group">
                            <input type="text" name="values[]" class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Please enter variation type" required>
                            <button type="button" class="remove-value-btn text-gray-400 hover:text-red-500 p-2 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="addValueBtn" class="mt-3 text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add More
                    </button>
                    @error('values') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <input type="hidden" name="status" value="1">

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 text-sm font-semibold hover:bg-gray-50 transition" onclick="closeModal('createModal')">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════
         EDIT VARIATION MODALS (Dynamic Values)
    ════════════════════════════════════════════════ --}}
    @foreach($variations as $variation)
    <div class="fixed inset-0 bg-black/45 backdrop-blur-sm flex items-center justify-center z-[9999] opacity-0 pointer-events-none transition-opacity duration-200 ease" id="editModal{{ $variation->id }}">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-2xl transform transition-all duration-200 ease scale-95" id="editModalBox{{ $variation->id }}">
            <div class="flex items-start justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-800">Edit Variation</h3>
                <button class="text-gray-400 hover:text-gray-600 text-2xl leading-none" onclick="closeModal('editModal{{ $variation->id }}')">&times;</button>
            </div>

            <form action="{{ route('variations.update', $variation->id) }}" method="POST" id="editForm{{ $variation->id }}">
                @csrf
                @method('PUT')

                {{-- Variation Name --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Name:<span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $variation->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Enter Name" required>
                </div>

                {{-- Variation Types (Dynamic List) --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Variation Types:<span class="text-red-500">*</span></label>
                    <div id="editValuesContainer{{ $variation->id }}" class="space-y-2.5">
                        @php
                            $oldValues = old('values', $variation->values ?? []);
                            if (!is_array($oldValues)) $oldValues = explode(',', $oldValues);
                            $oldValues = array_map('trim', $oldValues);
                        @endphp
                        @forelse($oldValues as $value)
                        <div class="flex items-center gap-2 value-group">
                            <input type="text" name="values[]" value="{{ $value }}" class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Please enter variation type" required>
                            <button type="button" class="remove-value-btn text-gray-400 hover:text-red-500 p-2 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        @empty
                        <div class="flex items-center gap-2 value-group">
                            <input type="text" name="values[]" class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Please enter variation type" required>
                            <button type="button" class="remove-value-btn text-gray-400 hover:text-red-500 p-2 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" class="addMoreEditBtn mt-3 text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1 transition" data-id="{{ $variation->id }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add More
                    </button>
                    @error('values') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <input type="hidden" name="status" value="{{ $variation->status }}">

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 text-sm font-semibold hover:bg-gray-50 transition" onclick="closeModal('editModal{{ $variation->id }}')">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md transition">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    {{-- ════════════════════════════════════════════════
         DELETE MODALS
    ════════════════════════════════════════════════ --}}
    @foreach($variations as $variation)
    <div class="fixed inset-0 bg-black/45 backdrop-blur-sm flex items-center justify-center z-[9999] opacity-0 pointer-events-none transition-opacity duration-200 ease" id="deleteModal{{ $variation->id }}">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl transform transition-all duration-200 ease scale-95">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Delete Variation</h3>
                <button class="text-gray-400 hover:text-gray-600 text-2xl leading-none" onclick="closeModal('deleteModal{{ $variation->id }}')">&times;</button>
            </div>
            <p class="text-gray-600 text-sm mb-6">
                Are you sure you want to delete <strong class="text-gray-800">{{ $variation->name }}</strong>? This action cannot be undone.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-600 text-sm font-semibold hover:bg-gray-50 transition" onclick="closeModal('deleteModal{{ $variation->id }}')">Cancel</button>
                <form action="{{ route('variations.destroy', $variation->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg shadow-md transition">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    {{-- ════════════════════════════════════════════════
         PAGE CONTENT
    ════════════════════════════════════════════════ --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Variations</h1>
            <p class="text-gray-500 text-sm mt-0.5">Manage all product variations</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md transition flex items-center gap-2" onclick="openModal('createModal')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Add Variation
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Variation Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Variation Types</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($variations as $variation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-800 text-sm">{{ $variation->name }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(($variation->values ?? []) as $value)
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-md">{{ $value }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openModal('editModal{{ $variation->id }}')" class="p-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button onclick="openModal('deleteModal{{ $variation->id }}')" class="p-2 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg transition" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <span>No Variations Found</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($variations->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $variations->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Global Modal Handlers
    function openModal(id) {
        const overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.classList.add('opacity-100', 'pointer-events-auto');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.remove('opacity-100', 'pointer-events-auto');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
    }

    // Close on outside click
    document.querySelectorAll('[id$="Modal"], [id$="Modal"]').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    // Escape key handler
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[class*="opacity-100 pointer-events-auto"]').forEach(modal => {
                if (modal.id && modal.id.includes('Modal')) closeModal(modal.id);
            });
        }
    });

    // ──────────────────────────────────────────────
    // CREATE MODAL: Dynamic Add/Remove Fields
    // ──────────────────────────────────────────────
    const createContainer = document.getElementById('variationValuesContainer');
    const addBtn = document.getElementById('addValueBtn');

    function createValueGroup(value = '') {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 value-group';
        div.innerHTML = `
            <input type="text" name="values[]" value="${value.replace(/"/g, '&quot;')}" class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Please enter variation type" required>
            <button type="button" class="remove-value-btn text-gray-400 hover:text-red-500 p-2 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        `;
        const removeBtn = div.querySelector('.remove-value-btn');
        removeBtn.addEventListener('click', function() {
            if (createContainer.children.length > 1) {
                div.remove();
            } else {
                alert('At least one variation type is required.');
            }
        });
        return div;
    }

    if (addBtn) {
        addBtn.addEventListener('click', function() {
            createContainer.appendChild(createValueGroup(''));
        });
    }

    // Initialize remove buttons for existing create modal fields (if any exists from old input)
    document.querySelectorAll('#variationValuesContainer .remove-value-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (createContainer.children.length > 1) {
                btn.closest('.value-group').remove();
            } else {
                alert('At least one variation type is required.');
            }
        });
    });

    // Ensure at least one value group remains on form submit for create modal
    const createForm = document.getElementById('createVariationForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            const groups = createContainer.querySelectorAll('.value-group');
            if (groups.length === 0) {
                e.preventDefault();
                alert('Please add at least one variation type.');
            }
        });
    }

    // ──────────────────────────────────────────────
    // EDIT MODALS: Dynamic Add/Remove Fields
    // ──────────────────────────────────────────────
    document.querySelectorAll('.addMoreEditBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const variationId = this.getAttribute('data-id');
            const container = document.getElementById(`editValuesContainer${variationId}`);
            if (container) {
                const newGroup = document.createElement('div');
                newGroup.className = 'flex items-center gap-2 value-group';
                newGroup.innerHTML = `
                    <input type="text" name="values[]" class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Please enter variation type" required>
                    <button type="button" class="remove-value-btn text-gray-400 hover:text-red-500 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                `;
                const removeBtn = newGroup.querySelector('.remove-value-btn');
                removeBtn.addEventListener('click', function() {
                    if (container.children.length > 1) {
                        newGroup.remove();
                    } else {
                        alert('At least one variation type is required.');
                    }
                });
                container.appendChild(newGroup);
            }
        });
    });

    // Initialize remove buttons for existing edit modal groups
    document.querySelectorAll('[id^="editValuesContainer"]').forEach(container => {
        container.querySelectorAll('.remove-value-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (container.children.length > 1) {
                    btn.closest('.value-group').remove();
                } else {
                    alert('At least one variation type is required.');
                }
            });
        });
    });

    // Auto-open create modal if validation errors exist for store route
    @if($errors->any() && old('_method') === null && old('name') !== null)
        openModal('createModal');
    @endif
</script>

@endsection