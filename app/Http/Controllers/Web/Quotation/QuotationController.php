<?php

namespace App\Http\Controllers\Web\Quotation;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Services\Quotation\QuotationService;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    protected $quotationService;

    public function __construct(QuotationService $quotationService)
    {
        $this->quotationService = $quotationService;
    }

    public function index()
    {
        $quotations = $this->quotationService->getAll();
        return view('quotations.index', compact('quotations'));
    }

    public function create()
    {
        $customers = Customer::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('quotations.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        // For simplicity using Request directly, ideally should use StoreQuotationRequest
        $items = [];
        if($request->product_id) {
            foreach ($request->product_id as $index => $productId) {
                $items[] = [
                    'product_id' => $productId,
                    'quantity' => $request->quantity[$index],
                    'price' => $request->price[$index],
                    'variation' => $request->variation_name[$index] ?? null,
                ];
            }
        }
        
        $data = $request->all();
        $data['items'] = $items;

        $this->quotationService->store($data);

        return redirect()->route('quotations.index')->with('success', 'Quotation Created Successfully');
    }

    public function show($id)
    {
        $quotation = $this->quotationService->findById($id);
        return view('quotations.show', compact('quotation'));
    }

    public function edit($id)
    {
        $quotation = $this->quotationService->findById($id);
        $customers = Customer::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('quotations.edit', compact('quotation', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $items = [];
        if($request->product_id) {
            foreach ($request->product_id as $index => $productId) {
                $items[] = [
                    'product_id' => $productId,
                    'quantity' => $request->quantity[$index],
                    'price' => $request->price[$index],
                    'variation' => $request->variation_name[$index] ?? null,
                ];
            }
        }
        
        $data = $request->all();
        $data['items'] = $items;

        $this->quotationService->update($data, $id);

        return redirect()->route('quotations.index')->with('success', 'Quotation Updated Successfully');
    }

    public function approve($id)
    {
        $this->quotationService->approve($id);
        return redirect()->back()->with('success', 'Quotation Approved Successfully');
    }

    public function convertToSale($id)
    {
        try {
            $this->quotationService->convertToSale($id);
            return redirect()->route('sales.index')->with('success', 'Quotation Converted to Sale Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->quotationService->delete($id);
        return redirect()->route('quotations.index')->with('success', 'Quotation Deleted Successfully');
    }
}
