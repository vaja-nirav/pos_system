<div class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">

    <h2 class="text-xl font-semibold"></h2>

    <div class="flex items-center gap-4">

        {{-- POS Button --}}
        @can('view_pos_screen')
        <a href="{{ route('pos.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg flex items-center gap-2 hover:bg-indigo-700 transition-colors">
            <span class="font-medium text-sm">POS</span>
        </a>
        @endcan

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

        {{-- Store Switcher --}}
        @if(isset($all_stores) && $all_stores->count() > 0)
            <div class="relative group" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100 hover:border-indigo-200 transition-all">
                    <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] text-gray-400 uppercase font-bold leading-none mb-1">Active Store</p>
                        <p class="text-sm font-bold text-gray-700 leading-none">{{ $active_store->name ?? 'Select Store' }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div 
                    x-show="open" 
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    class="absolute top-full right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 z-[100] p-2"
                    style="display: none;"
                >
                    @foreach($all_stores as $store)
                        <form action="{{ route('switch-store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="store_id" value="{{ $store->id }}">
                            <button type="submit" class="w-full flex items-center justify-between p-3 rounded-xl transition-all {{ ($active_store->id ?? null) == $store->id ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-50 text-gray-600' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full {{ ($active_store->id ?? null) == $store->id ? 'bg-indigo-500' : 'bg-gray-300' }}"></div>
                                    <span class="font-bold text-sm">{{ $store->name }}</span>
                                </div>
                                @if(($active_store->id ?? null) == $store->id)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        @endif

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
