@php
    $alertThreshold = $alert ?? 10;
@endphp

@if($stock <= 0)
    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-red-100">
        <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
        Out of Stock
    </span>
@elseif($stock <= $alertThreshold)
    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-orange-50 text-orange-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-orange-100">
        <span class="w-1.5 h-1.5 rounded-full bg-orange-600"></span>
        Low Stock
    </span>
@else
    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-green-100">
        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
        In Stock
    </span>
@endif
