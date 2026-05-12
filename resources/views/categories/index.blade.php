@extends('layouts.app')

@section('content')

<style>
    /* ── Modal Overlay ── */
    .cat-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.45);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s ease;
    }
    .cat-modal-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    /* ── Modal Box ── */
    .cat-modal {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 460px;
        padding: 32px 28px 24px;
        box-shadow: 0 24px 60px rgba(0,0,0,.18);
        transform: translateY(24px) scale(.97);
        transition: transform .25s ease, opacity .25s ease;
        position: relative;
    }
    .cat-modal-overlay.open .cat-modal {
        transform: translateY(0) scale(1);
    }

    /* ── Modal Header ── */
    .cat-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 22px;
    }
    .cat-modal-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1a2e;
    }
    .cat-modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        font-size: 1.4rem;
        line-height: 1;
        transition: color .2s;
        padding: 0;
    }
    .cat-modal-close:hover { color: #374151; }

    /* ── Form fields ── */
    .cat-field-label {
        display: block;
        font-size: .82rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .cat-field-label span { color: #ef4444; }
    .cat-input {
        width: 100%;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: .92rem;
        color: #111827;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
    }
    .cat-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }

    /* ── Image upload ── */
    .cat-image-wrap {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 12px;
        border: 2px dashed #d1d5db;
        overflow: hidden;
        cursor: pointer;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color .2s;
    }
    .cat-image-wrap:hover { border-color: #6366f1; }
    .cat-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        inset: 0;
    }
    .cat-image-wrap .cam-icon {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 22px;
        height: 22px;
        background: #6366f1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cat-image-wrap .cam-icon svg { width: 11px; height: 11px; fill: #fff; }
    .cat-placeholder-icon { color: #9ca3af; }

    /* ── Footer buttons ── */
    .cat-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 28px;
    }
    .btn-cancel {
        padding: 9px 22px;
        border: 1.5px solid #d1d5db;
        border-radius: 10px;
        background: #fff;
        color: #6b7280;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, border-color .2s;
    }
    .btn-cancel:hover { background: #f3f4f6; border-color: #9ca3af; }
    .btn-save {
        padding: 9px 26px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        color: #fff;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        box-shadow: 0 4px 12px rgba(99,102,241,.3);
    }
    .btn-save:hover { opacity: .9; transform: translateY(-1px); }

    /* ── Status select ── */
    .cat-select {
        width: 100%;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: .92rem;
        color: #111827;
        outline: none;
        background: #fff;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        cursor: pointer;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
    }
    .cat-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .field-error { color: #ef4444; font-size: .78rem; margin-top: 4px; }

    /* ── Page Create Button ── */
    .btn-create-cat {
        padding: 9px 20px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        color: #fff;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        box-shadow: 0 4px 12px rgba(99,102,241,.25);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-create-cat:hover { opacity: .9; transform: translateY(-1px); }

    /* ── Edit / Delete action icons ── */
    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        transition: background .2s, transform .15s;
    }
    .action-btn:hover { transform: scale(1.1); }
    .action-btn.edit { background: #eef2ff; color: #6366f1; }
    .action-btn.delete { background: #fef2f2; color: #ef4444; }
    .action-btn.edit:hover { background: #e0e7ff; }
    .action-btn.delete:hover { background: #fee2e2; }
</style>

{{-- ════════════════════════════════════════════════
     CREATE CATEGORY MODAL
════════════════════════════════════════════════ --}}
<div class="cat-modal-overlay" id="createModal">
    <div class="cat-modal" id="createModalBox">
        <div class="cat-modal-header">
            <span class="cat-modal-title">Create Product Category</span>
            <button class="cat-modal-close" onclick="closeModal('createModal')" title="Close">&times;</button>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Name --}}
            <div style="margin-bottom:18px;">
                <label class="cat-field-label" for="create_name">Name:<span>*</span></label>
                <input
                    id="create_name"
                    class="cat-input"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter Name"
                    required
                >
                @error('name')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Logo / Image --}}
            <div style="margin-bottom:18px;">
                <label class="cat-field-label">Change Logo:</label>
                <div style="display:flex;align-items:center;gap:14px;">
                    <div class="cat-image-wrap" onclick="document.getElementById('create_image_input').click()">
                        <img id="create_img_preview" src="" alt="" style="display:none;">
                        <svg class="cat-placeholder-icon" style="width:30px;height:30px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div class="cam-icon">
                            <svg viewBox="0 0 24 24" fill="white"><path d="M12 15.2A3.2 3.2 0 1012 8.8a3.2 3.2 0 000 6.4zM9 3L7.17 5H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V7a2 2 0 00-2-2h-3.17L15 3H9z"/></svg>
                        </div>
                    </div>
                    <input id="create_image_input" type="file" name="image" accept="image/*" style="display:none;" onchange="previewImage(event,'create_img_preview')">
                </div>
                @error('image')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div style="margin-bottom:8px;">
                <label class="cat-field-label" for="create_status">Status:</label>
                <select id="create_status" class="cat-select" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="cat-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('createModal')">Cancel</button>
                <button type="submit" class="btn-save">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════════
     EDIT CATEGORY MODALS (one per category)
════════════════════════════════════════════════ --}}
@foreach($categories as $category)
<div class="cat-modal-overlay" id="editModal{{ $category->id }}">
    <div class="cat-modal" id="editModalBox{{ $category->id }}">
        <div class="cat-modal-header">
            <span class="cat-modal-title">Edit Product Category</span>
            <button class="cat-modal-close" onclick="closeModal('editModal{{ $category->id }}')" title="Close">&times;</button>
        </div>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div style="margin-bottom:18px;">
                <label class="cat-field-label" for="edit_name_{{ $category->id }}">Name:<span>*</span></label>
                <input
                    id="edit_name_{{ $category->id }}"
                    class="cat-input"
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    placeholder="Enter Name"
                    required
                >
            </div>

            {{-- Logo / Image --}}
            <div style="margin-bottom:18px;">
                <label class="cat-field-label">Change Logo:</label>
                <div style="display:flex;align-items:center;gap:14px;">
                    <div class="cat-image-wrap" onclick="document.getElementById('edit_image_input_{{ $category->id }}').click()">
                        @if($category->getFirstMediaUrl('categories'))
                            <img id="edit_img_preview_{{ $category->id }}"
                                 src="{{ $category->getFirstMediaUrl('categories') }}"
                                 alt="{{ $category->name }}"
                                 style="display:block;"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&color=7F9CF5&background=EBF4FF';">
                        @else
                            <img id="edit_img_preview_{{ $category->id }}" src="" alt="" style="display:none;">
                            <svg class="cat-placeholder-icon" style="width:30px;height:30px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                        <div class="cam-icon">
                            <svg viewBox="0 0 24 24" fill="white"><path d="M12 15.2A3.2 3.2 0 1012 8.8a3.2 3.2 0 000 6.4zM9 3L7.17 5H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V7a2 2 0 00-2-2h-3.17L15 3H9z"/></svg>
                        </div>
                    </div>
                    <input id="edit_image_input_{{ $category->id }}" type="file" name="image" accept="image/*" style="display:none;"
                           onchange="previewImage(event,'edit_img_preview_{{ $category->id }}')">
                    <span style="font-size:.8rem;color:#6b7280;">Click to change image</span>
                </div>
            </div>

            {{-- Status --}}
            <div style="margin-bottom:8px;">
                <label class="cat-field-label" for="edit_status_{{ $category->id }}">Status:</label>
                <select id="edit_status_{{ $category->id }}" class="cat-select" name="status">
                    <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="cat-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal{{ $category->id }}')">Cancel</button>
                <button type="submit" class="btn-save">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- ════════════════════════════════════════════════
     DELETE MODALS
════════════════════════════════════════════════ --}}
@foreach($categories as $category)
<div class="cat-modal-overlay" id="deleteModal{{ $category->id }}">
    <div class="cat-modal" style="max-width:400px;" id="deleteModalBox{{ $category->id }}">
        <div class="cat-modal-header">
            <span class="cat-modal-title">Delete Category</span>
            <button class="cat-modal-close" onclick="closeModal('deleteModal{{ $category->id }}')" title="Close">&times;</button>
        </div>
        <p style="color:#6b7280;font-size:.92rem;margin-bottom:24px;">
            Are you sure you want to delete <strong>{{ $category->name }}</strong>? This action cannot be undone.
        </p>
        <div class="cat-modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('deleteModal{{ $category->id }}')">Cancel</button>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:9px 22px;border:none;border-radius:10px;background:linear-gradient(135deg,#ef4444,#f87171);color:#fff;font-size:.88rem;font-weight:600;cursor:pointer;">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- ════════════════════════════════════════════════
     PAGE CONTENT
════════════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Product Categories</h1>
        <p class="text-gray-500 text-sm">Manage all product categories</p>
    </div>

    @can('create_product_categories')
    <button class="btn-create-cat" onclick="openModal('createModal')">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Create Product Category
    </button>
    @endcan
</div>

{{-- Success / Error flash --}}
<!-- @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:12px 16px;margin-bottom:16px;color:#16a34a;font-size:.88rem;display:flex;align-items:center;gap:8px;">
        <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
@endif -->

<x-card>

    <x-table>

        <thead class="bg-gray-50">
            <tr>
                <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" style="width:48px;">
                    <input type="checkbox" style="border-radius:4px;cursor:pointer;">
                </th>
                <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Product Category</th>
                <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($categories as $category)

                <tr class="border-t hover:bg-gray-50 transition-colors" style="transition:background .15s;">

                    <td class="p-4">
                        <input type="checkbox" style="border-radius:4px;cursor:pointer;">
                    </td>

                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            @if($category->getFirstMediaUrl('categories'))
                                <img
                                    src="{{ $category->getFirstMediaUrl('categories') }}"
                                    class="w-10 h-10 rounded-lg object-cover shadow-sm border border-gray-200"
                                    alt="{{ $category->name }}"
                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&color=7F9CF5&background=EBF4FF';"
                                >
                            @else
                                <div style="width:40px;height:40px;border-radius:10px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;">
                                    <svg style="width:18px;height:18px;color:#9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <span class="font-medium text-gray-800" style="font-size:.9rem;">{{ $category->name }}</span>
                        </div>
                    </td>

                    <td class="p-4">
                        @if($category->status)
                            <span style="padding:4px 12px;background:#f0fdf4;color:#16a34a;border-radius:999px;font-size:.78rem;font-weight:600;border:1px solid #bbf7d0;">
                                Active
                            </span>
                        @else
                            <span style="padding:4px 12px;background:#fef2f2;color:#dc2626;border-radius:999px;font-size:.78rem;font-weight:600;border:1px solid #fecaca;">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td class="p-4">
                        <div style="display:flex;align-items:center;gap:8px;">
                            {{-- Edit --}}
                            @can('update_product_categories')
                            <button
                                class="action-btn edit"
                                onclick="openModal('editModal{{ $category->id }}')"
                                title="Edit {{ $category->name }}"
                            >
                                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            @endcan

                            {{-- Delete --}}
                            @can('delete_product_categories')
                            <button
                                class="action-btn delete"
                                onclick="openModal('deleteModal{{ $category->id }}')"
                                title="Delete {{ $category->name }}"
                            >
                                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            @endcan
                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="p-10 text-center text-gray-400" style="font-size:.9rem;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:10px;">
                            <svg style="width:40px;height:40px;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            No Categories Found
                        </div>
                    </td>
                </tr>

            @endforelse

        </tbody>

    </x-table>

    <div class="mt-5">
        {{ $categories->links() }}
    </div>

</x-card>

{{-- ════════════════════════════════════════════════
     JS
════════════════════════════════════════════════ --}}
<script>
    function openModal(id) {
        const overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Close on overlay click (outside box)
    document.querySelectorAll('.cat-modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.cat-modal-overlay.open').forEach(el => closeModal(el.id));
        }
    });

    // Image preview helper
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        if (!file) return;
        const img = document.getElementById(previewId);
        if (!img) return;
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            img.style.display = 'block';
            // hide placeholder svg
            const wrap = img.closest('.cat-image-wrap');
            if (wrap) {
                const svg = wrap.querySelector('svg.cat-placeholder-icon');
                if (svg) svg.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }

    // Auto-open create modal if there were validation errors on store
    @if($errors->any() && old('_method') === null && old('name') !== null)
        openModal('createModal');
    @endif

    // Hash-based auto-open (when redirected from create.blade.php / edit.blade.php)
    (function() {
        const hash = window.location.hash;
        if (!hash) return;
        if (hash === '#openCreate') {
            openModal('createModal');
        } else if (hash.startsWith('#editModal')) {
            openModal(hash.slice(1));
        }
        // Clean hash from URL bar without reloading
        history.replaceState(null, '', window.location.pathname + window.location.search);
    })();
</script>

@endsection