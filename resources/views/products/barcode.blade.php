<!DOCTYPE html>
<html>
<head>
    <title>Barcode - {{ $product->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hide everything else and center the label during printing */
        @media print {
            .no-print { display: none !important; }
            body { 
                padding: 0 !important; 
                margin: 0 !important; 
                background: white !important; 
            }
            .print-box {
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen p-4">

<div class="w-full text-center print-box">

    <h2 class="text-2xl font-bold mb-2">
        {{ $product->name }}
    </h2>

    <p class="mb-4 text-gray-600">
        SKU : {{ $product->sku }}
    </p>

    <div class="my-6 flex justify-center">
        {!! DNS1D::getBarcodeHTML(
            $product->sku,
            'C128'
        ) !!}
    </div>

    <p class="text-3xl font-bold mt-6 text-gray-800">
        ₹{{ number_format($product->selling_price, 2) }}
    </p>

</div>

</body>
</html>