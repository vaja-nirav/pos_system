<?php

namespace App\Http\Controllers\Web\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StoreSwitcherController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id'
        ]);

        Session::put('active_store_id', $request->store_id);

        $store = Store::find($request->store_id);

        return back()->with('success', "Switched to {$store->name}");
    }
}
