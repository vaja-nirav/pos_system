<div class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">

    <h2 class="text-xl font-semibold">
        {{-- @yield('page_title', 'Dashboard') --}}
    </h2>

    <div class="flex items-center gap-4">

        {{-- POS Button --}}
        <a href="{{ route('pos.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg flex items-center gap-2 hover:bg-indigo-700 transition-colors">
            <span class="font-medium text-sm">POS</span>
        </a>

        {{-- Full Screen Toggle --}}
        <button 
            onclick="toggleFullScreen()" 
            class="w-10 h-10 border border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg flex items-center justify-center transition-all shadow-sm group"
            title="Full Screen"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
            </svg>
        </button>

        <div class="h-8 w-[1px] bg-gray-200 mx-2"></div>

        <span class="font-medium text-gray-700">
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="text-red-500 hover:text-red-700 font-medium transition-colors">
                Logout
            </button>
        </form>

    </div>

</div>

<script>
    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }
</script>
