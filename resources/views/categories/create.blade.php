@extends('layouts.app')

@section('content')

{{-- Redirect to index and open the create modal automatically --}}
<meta http-equiv="refresh" content="0;url={{ route('categories.index') }}#openCreate">

<script>
    // Immediately redirect to index with a hash that triggers the modal
    window.location.href = "{{ route('categories.index') }}#openCreate";
</script>

@endsection