<div 
    x-data="{ 
        openMenu: @if(request()->is('products*') || request()->is('categories*') || request()->is('units*') || request()->is('brands*') || request()->is('variations*')) 'product' 
                  @elseif(request()->is('customers*') || request()->is('suppliers*') || request()->is('users*')) 'people'
                  @elseif(request()->is('purchases*')) 'purchase'
                  @elseif(request()->is('sales*') && !request()->is('pos*')) 'sales'
                  @elseif(request()->is('reports*')) 'reports'
                  @elseif(request()->is('expenses*') || request()->is('expense-categories*')) 'expense'
                  @else null @endif,
        toggle(menu) {
            this.openMenu = this.openMenu === menu ? null : menu;
        }
    }"
    class="w-72 bg-white shadow-xl min-h-screen flex flex-col border-r border-gray-100"
>
    <!-- Logo Section -->
    <div class="p-[22px] border-b border-gray-5">
        <a href="{{ route('dashboard') }}">
            <h1 class="text-xl font-black tracking-tight text-gray-800">
                POS <span class="text-indigo-600">SYSTEM</span>
            </h1>
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 px-4 py-2 overflow-y-auto custom-scrollbar">
        <ul class="space-y-1.5">
            
            <!-- 1. Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- 2. Product -->
            <li class="space-y-1">
                <button 
                    @click="toggle('product')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->is('products*') || request()->is('categories*') || request()->is('units*') || request()->is('brands*') || request()->is('variations*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        <span class="font-medium">Product</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="openMenu === 'product' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="openMenu === 'product'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('products.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('products.index') ? 'text-indigo-600 font-bold' : '' }}">Products</a>
                    <a href="{{ route('categories.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('categories.index') ? 'text-indigo-600 font-bold' : '' }}">Categories</a>
                    <a href="{{ route('units.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('units.index') ? 'text-indigo-600 font-bold' : '' }}">Units</a>
                    <a href="{{ route('brands.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('brands.index') ? 'text-indigo-600 font-bold' : '' }}">Brand</a>
                    <a href="{{ route('variations.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('variations.index') ? 'text-indigo-600 font-bold' : '' }}">Variations</a>
                </div>
            </li>

            <!-- 3. People -->
            <li class="space-y-1">
                <button 
                    @click="toggle('people')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->is('customers*') || request()->is('suppliers*') || request()->is('users*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <span class="font-medium">People</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="openMenu === 'people' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="openMenu === 'people'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('customers.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('customers.*') ? 'text-indigo-600 font-bold' : '' }}">Customers</a>
                    <a href="{{ route('suppliers.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('suppliers.*') ? 'text-indigo-600 font-bold' : '' }}">Suppliers</a>
                    <a href="{{ route('users.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('users.*') ? 'text-indigo-600 font-bold' : '' }}">Users</a>
                </div>
            </li>

            <!-- 4. Purchase -->
            <li class="space-y-1">
                <button 
                    @click="toggle('purchase')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->is('purchases*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        <span class="font-medium">Purchase</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="openMenu === 'purchase' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="openMenu === 'purchase'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('purchases.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('purchases.index') ? 'text-indigo-600 font-bold' : '' }}">Purchase</a>
                </div>
                <div x-show="openMenu === 'purchase'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('purchase-returns.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('purchase-returns.index') ? 'text-indigo-600 font-bold' : '' }}">Purchase Return</a>
                </div>
            </li>

            <!-- 5. Sales -->
            <li class="space-y-1">
                <button 
                    @click="toggle('sales')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->is('sales*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        <span class="font-medium">Sales</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="openMenu === 'sales' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="openMenu === 'sales'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('sales.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('sales.index') ? 'text-indigo-600 font-bold' : '' }}">Sales</a>
                </div>
                <div x-show="openMenu === 'sales'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('sale-returns.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('sale-returns.index') ? 'text-indigo-600 font-bold' : '' }}">Sale Return</a>
                </div>
            </li>

            <!-- 6. Reports -->
            <li class="space-y-1">
                <button 
                    @click="toggle('reports')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->is('reports*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <span class="font-medium">Reports</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="openMenu === 'reports' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="openMenu === 'reports'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('reports.sales') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('reports.sales') ? 'text-indigo-600 font-bold' : '' }}">Sales report</a>
                    <a href="{{ route('reports.purchases') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('reports.purchases') ? 'text-indigo-600 font-bold' : '' }}">Purchase Report</a>
                    <a href="{{ route('reports.stock') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('reports.stock') ? 'text-indigo-600 font-bold' : '' }}">Stock Report</a>
                    <a href="{{ route('reports.profit') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('reports.profit') ? 'text-indigo-600 font-bold' : '' }}">Profit Report</a>
                </div>
            </li>

            <!-- 7. Expense -->
            <li class="space-y-1">
                <button 
                    @click="toggle('expense')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->is('expenses*') || request()->is('expense-categories*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        <span class="font-medium">Expense</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="openMenu === 'expense' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="openMenu === 'expense'" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('expenses.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('expenses.index') ? 'text-indigo-600 font-bold' : '' }}">Expenses</a>
                    <a href="{{ route('expense-categories.index') }}" class="block py-2 text-sm text-gray-500 hover:text-indigo-600 transition-colors {{ request()->routeIs('expense-categories.index') ? 'text-indigo-600 font-bold' : '' }}">Expense Categories</a>
                </div>
            </li>

            <!-- 8. Roles & Permissions -->
            @can('view_roles')
            <li class="space-y-1">
                <a 
                    href="{{ route('roles.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('roles.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="font-medium">Roles/Permissions</span>
                </a>
            </li>
            @endcan

            <!-- 9. Warehouse -->
            <li class="space-y-1">
                <a 
                    href="{{ route('warehouses.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('warehouses.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="font-medium">Warehouse</span>
                </a>
            </li>

        </ul>
    </div>
</div>