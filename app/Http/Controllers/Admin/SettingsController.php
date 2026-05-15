<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = DB::table('settings')->get();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['sometimes', 'array'],
            'settings.*' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated['settings'] ?? [] as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function analytics(): View
    {
        $analytics = [
            'total_orders' => DB::table('orders')->count(),
            'total_revenue' => DB::table('orders')->sum('total_price'),
            'total_customers' => DB::table('users')->where('role', 'customer')->count(),
            'total_deliveries' => DB::table('deliveries')->count(),
        ];

        return view('admin.analytics.index', compact('analytics'));
    }
}
