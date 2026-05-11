@extends('layouts.app')

@section('content')

{{-- Redirect to index and open the edit modal for this category --}}
<meta http-equiv="refresh" content="0;url={{ route('categories.index') }}#editModal{{ $category->id }}">

<script>
    // Immediately redirect to index with a hash that triggers the edit modal
    window.location.href = "{{ route('categories.index') }}#editModal{{ $category->id }}";
</script>

@endsection