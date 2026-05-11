<?php

namespace App\Http\ViewComposers;

use App\Models\Store;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class StoreComposer
{
    public function compose(View $view)
    {
        $stores = Store::where('status', 1)->get();
        $activeStoreId = Session::get('active_store_id');
        $activeStore = $stores->where('id', $activeStoreId)->first() ?: $stores->first();

        // If no store is in session, set the first one as default
        if (!$activeStoreId && $activeStore) {
            Session::put('active_store_id', $activeStore->id);
        }

        $view->with([
            'all_stores' => $stores,
            'active_store' => $activeStore
        ]);
    }
}
