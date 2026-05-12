<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Handle file uploads
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                
                // Delete old file if exists
                $oldValue = Setting::get($key);
                if ($oldValue) {
                    Storage::disk('public')->delete($oldValue);
                }
                
                $value = $path;
            }

            // Handle toggles (checkboxes) - if key is missing in request but expected, we might need to handle it.
            // But usually we send them as hidden fields or handle them specifically.

            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Handle bulk update for specific groups.
     */
    public function bulkUpdate(Request $request)
    {
        $settings = $request->all();
        
        foreach ($settings as $key => $value) {
            if ($key === '_token' || $key === '_method') continue;

            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('settings', 'public');
                Setting::set($key, $path);
            } else {
                Setting::set($key, $value);
            }
        }

        return response()->json(['message' => 'Settings updated successfully']);
    }
}
