<?php

namespace App\Http\Controllers\Web\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $sale = Sale::with(['customer','items.product'])->findOrFail($id);

        return view('invoice.show', compact('sale'));
    }

    public function pdf($id)
    {
        $sale = Sale::with(['customer','items.product'])->findOrFail($id);

        $pdf = Pdf::loadView('invoice.pdf', compact('sale'));
        
        return $pdf->download('invoice-' . $sale->invoice_no . '.pdf');
    }
}