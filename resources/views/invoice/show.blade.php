<!DOCTYPE html>
<html>
<head>

    <title>
        Invoice
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 py-10">

<div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-10">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b pb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                POS Invoice
            </h1>

            <p class="text-gray-500">
                Professional Billing System
            </p>

        </div>

        <div class="text-right">

            <h2 class="text-xl font-bold">
                #{{ $sale->invoice_no }}
            </h2>

            <p>
                {{ date('d M Y', strtotime($sale->sale_date)) }}
            </p>

        </div>

    </div>

    {{-- Customer --}}
    <div class="mt-8 flex justify-between">

        <div>

            <h3 class="font-semibold text-lg">
                Customer
            </h3>

            <p>
                {{ $sale->customer->name ?? 'Walk-in Customer' }}
            </p>

            <p>
                {{ $sale->customer->phone ?? '-' }}
            </p>

        </div>

        <div>

            @if($sale->payment_status == 'paid')

                <span class="px-4 py-2 bg-green-100 text-green-600 rounded-full">
                    Paid
                </span>

            @elseif($sale->payment_status == 'partial')

                <span class="px-4 py-2 bg-yellow-100 text-yellow-600 rounded-full">
                    Partial
                </span>

            @else

                <span class="px-4 py-2 bg-red-100 text-red-600 rounded-full">
                    Due
                </span>

            @endif

        </div>

    </div>

    {{-- Items --}}
    <table class="w-full mt-8 border">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Product
                </th>

                <th class="p-4">
                    Qty
                </th>

                <th class="p-4">
                    Price
                </th>

                <th class="p-4">
                    Total
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($sale->items as $item)

                <tr class="border-t">

                    <td class="p-4">
                        {{ $item->product->name }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $item->quantity }}
                    </td>

                    <td class="p-4 text-center">
                        ₹{{ number_format($item->price,2) }}
                    </td>

                    <td class="p-4 text-center">
                        ₹{{ number_format($item->subtotal,2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    {{-- Totals --}}
    <div class="mt-8 flex justify-end">

        <div class="w-80 space-y-3">

            <div class="flex justify-between">
                <span>Total</span>
                <span>₹{{ number_format($sale->total,2) }}</span>
            </div>

            <div class="flex justify-between">
                <span>Paid</span>
                <span>₹{{ number_format($sale->paid_amount,2) }}</span>
            </div>

            <div class="flex justify-between text-red-600 font-bold">
                <span>Due</span>
                <span>₹{{ number_format($sale->due_amount,2) }}</span>
            </div>

        </div>

    </div>

    {{-- Buttons --}}
    <div class="mt-10 flex gap-4">

        <button
            onclick="window.print()"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg"
        >
            Print Invoice
        </button>

        <a
            href="{{ route('invoice.pdf',$sale->id) }}"
            class="px-6 py-3 bg-green-600 text-white rounded-lg"
        >
            Download PDF
        </a>

    </div>

</div>

</body>
</html>