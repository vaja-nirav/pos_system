<?php

namespace App\Http\Controllers\Web\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::withCount(['products', 'sales'])->get();
        
        // Find store with most products
        $storeWithMostProducts = $stores->sortByDesc('products_count')->first();
        
        // Find store with most sales (collections)
        $storeWithMostSales = $stores->sortByDesc('sales_count')->first();

        return view('stores.index', compact('stores', 'storeWithMostProducts', 'storeWithMostSales'));
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|unique:stores,code',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        Store::create($request->all());

        return redirect()->route('stores.index')->with('success', 'Store created successfully.');
    }

    public function edit(Store $store)
    {
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|unique:stores,code,' . $store->id,
        ]);

        $store->update($request->all());

        return redirect()->route('stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('stores.index')->with('success', 'Store deleted successfully.');
    }
}
