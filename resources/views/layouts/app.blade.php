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
    <style>
        .toast-success { background-color: #4F46E5 !important; }
        .toast-error { background-color: #EF4444 !important; }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col h-full overflow-hidden">

        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Scrollable Content Area --}}
        <div class="flex-1 overflow-y-auto bg-gray-100 no-scrollbar">
            {{-- Alert Section --}}
            <x-alert />

            {{-- Main Content --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>

    </div>

</div>

    @stack('scripts')
</body>
</html>