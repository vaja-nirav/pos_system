<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                if ($oldValue && Storage::disk('public')->exists($oldValue)) {
                    Storage::disk('public')->delete($oldValue);
                }
                
                $value = $path;
            }

            // For checkboxes that are not present in request when unchecked
            // We might need a list of expected checkboxes, but for now we'll handle them in the view with hidden inputs
            
            Setting::set($key, $value);
        }

        // Log the activity
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'module' => 'Settings',
            'description' => 'System settings were updated by ' . auth()->user()->name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function clearCache()
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        
        return response()->json(['message' => 'System cache cleared successfully']);
    }

    public function clearLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
        }
        
        return response()->json(['message' => 'System logs cleared successfully']);
    }
}
