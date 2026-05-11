<?php

namespace App\Http\Controllers\Web\Barcode;

use App\Http\Controllers\Controller;
use App\Models\Product;

class BarcodeController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view(
            'products.barcode',
            compact('product')
        );
    }
}