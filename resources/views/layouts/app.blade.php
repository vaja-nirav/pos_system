<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>POS System</title>
    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- jQuery and Toastr JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .toast-success { background-color: #4F46E5 !important; }
        .toast-error { background-color: #EF4444 !important; }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col">

        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Alert Section --}}
        <x-alert />

        {{-- Main Content --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>