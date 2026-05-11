<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- jQuery and Toastr JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .toast-success { background-color: #4F46E5 !important; }
        .toast-error { background-color: #EF4444 !important; }
    </style>
</head>
<body class="bg-[#F3F4F6] overflow-hidden font-sans">

    <div
        x-data="posHandler()"
        class="h-screen flex flex-col"
    >
        {{-- Toastr Script --}}
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "3000"
                };
            });
        </script>
        {{-- POS Topbar --}}
        <header class="bg-white border-b border-gray-100 px-4 py-2.5 flex justify-between items-center z-50">
            <div class="flex items-center gap-4 flex-1">
                {{-- Customer Selector --}}
                <div class="flex items-center gap-2 w-64">
                    <div class="relative flex-1">
                        <select class="w-full bg-[#F3F4F6] border-none rounded-xl px-4 py-2.5 text-sm font-medium text-gray-600 focus:ring-0 appearance-none">
                            <option>walk-in-custo...</option>
                            @foreach($customers ?? [] as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Warehouse Selector --}}
                <div class="relative w-64">
                    <select class="w-full bg-[#F3F4F6] border-none rounded-xl px-4 py-2.5 text-sm font-medium text-gray-600 focus:ring-0 appearance-none">
                        <option>warehouse</option>
                        @foreach($warehouses ?? [] as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="relative flex-1 max-w-xl">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </span>
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Scan/Search Product by Code Name"
                        class="w-full bg-[#F3F4F6] border-none rounded-xl pl-12 pr-4 py-2.5 text-sm focus:ring-0"
                    >
                </div>
            </div>

            {{-- Right Icons --}}
            <div class="flex items-center gap-2 ml-4">
                <a href="/dashboard" class="w-9 h-9 bg-[#5D5FEF] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></a>
                <button class="w-9 h-9 bg-[#FF6B9B] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg></button>
                <button class="w-9 h-9 bg-[#5D5FEF] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg></button>
                <button class="w-9 h-9 bg-[#10B981] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg></button>
                <button onclick="toggleFullScreen()" class="w-9 h-9 bg-[#5D5FEF] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" /></svg></button>
                <button class="w-9 h-9 bg-[#5D5FEF] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg></button>
                <button class="w-9 h-9 bg-[#5D5FEF] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></button>
            </div>
        </header>

        {{-- Main POS Content --}}
        <main class="flex-1 overflow-hidden p-3 bg-[#F3F4F6]">
            @yield('content')
        </main>
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

        function posHandler()
        {
            return {
                search: '',
                selectedCategory: 'all',
                selectedBrand: 'all',
                customer: '',
                cart: [],
                subtotal: 0,
                taxPercent: '',
                tax: 0,
                discountType: 'fixed',
                discount: '',
                shipping: '',
                grandTotal: 0,
                totalQty: 0,
                checkoutModal: false,
                paymentStatus: 'paid',
                paymentType: 'Cash',
                note: '',
                paidAmount: '',
                invoiceModal: false,
                currentSale: null,

                addToCart(product) {
                    let existing = this.cart.find(item => item.id === product.id);
                    if(existing) {
                        if(existing.qty < existing.stock) {
                            existing.qty++;
                        }
                    } else {
                        this.cart.push({...product, qty: 1, stock: product.stock});
                    }
                    this.calculateTotals();
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                    this.calculateTotals();
                },

                increaseQty(index) {
                    if(this.cart[index].qty < this.cart[index].stock) {
                        this.cart[index].qty++;
                    }
                    this.calculateTotals();
                },

                decreaseQty(index) {
                    if(this.cart[index].qty > 1) {
                        this.cart[index].qty--;
                    }
                    this.calculateTotals();
                },

                resetCart() {
                    this.cart = [];
                    this.calculateTotals();
                },

                calculateTotals() {
                    this.subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                    this.totalQty = this.cart.reduce((sum, item) => sum + item.qty, 0);
                    
                    let taxVal = parseFloat(this.taxPercent || 0);
                    this.tax = (this.subtotal * taxVal) / 100;
                    
                    let discountAmount = 0;
                    let discountVal = parseFloat(this.discount || 0);
                    if(this.discountType == 'percentage') {
                        discountAmount = (this.subtotal * discountVal) / 100;
                    } else {
                        discountAmount = discountVal;
                    }
                    
                    let shippingVal = parseFloat(this.shipping || 0);
                    this.grandTotal = this.subtotal + this.tax + shippingVal - discountAmount;
                    this.paidAmount = this.grandTotal;
                },

                async submitSale(shouldPrint = false) {
                    if (this.cart.length === 0) {
                        toastr.error('Cart is empty');
                        return;
                    }

                    const data = {
                        customer_id: this.customer,
                        subtotal: this.subtotal,
                        discount: parseFloat(this.discount || 0),
                        tax: this.tax,
                        tax_percent: parseFloat(this.taxPercent || 0),
                        shipping: parseFloat(this.shipping || 0),
                        total: this.grandTotal,
                        paid_amount: parseFloat(this.paidAmount || 0),
                        payment_status: this.paymentStatus,
                        payment_type: this.paymentType,
                        note: this.note,
                        items: this.cart
                    };

                    try {
                        const response = await fetch('{{ route("pos.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(data)
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.currentSale = result.sale;
                            this.checkoutModal = false;
                            
                            if (shouldPrint) {
                                this.invoiceModal = true;
                            } else {
                                toastr.success('Sale created successfully');
                                this.resetCart();
                                // Reset other fields
                                this.taxPercent = '';
                                this.discount = '';
                                this.shipping = '';
                                this.note = '';
                                this.paymentType = 'Cash';
                                this.paymentStatus = 'paid';
                            }
                        } else {
                            toastr.error('Error: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Error submitting sale:', error);
                        toastr.error('An unexpected error occurred.');
                    }
                },

                printReceipt() {
                    const printContents = document.getElementById('receipt-content').innerHTML;
                    const originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    location.reload(); // Reload to restore state
                }
            }
        }
    </script>
</body>
</html>
