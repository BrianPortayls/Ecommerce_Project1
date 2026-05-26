<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $totalOrders = DB::table('orders')->count();
        $totalRevenue = DB::table('orders')->sum('total_price');
        $totalDeliveries = DB::table('deliveries')->count();

        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $weeklyRevenue = DB::table('orders')
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->get(['total_price', 'created_at'])
            ->groupBy(fn (object $order): string => Carbon::parse($order->created_at)->format('D'));

        $weeklyLabels = collect(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);

        $mealCategoryCounts = DB::table('menu_items')
            ->select('category', DB::raw('count(*) as aggregate'))
            ->groupBy('category')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'category');

        $topMeals = collect([
            ['name' => 'Tapsilog Express', 'sold' => 454],
            ['name' => 'Porksilog Bistro', 'sold' => 392],
            ['name' => 'Cornsilog Kitchen', 'sold' => 284],
            ['name' => 'Chicken Rice Bowl', 'sold' => 246],
            ['name' => 'Sizzling Pork Plate', 'sold' => 198],
        ]);

        $analytics = [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_customers' => DB::table('users')->where('role', 'customer')->count(),
            'total_deliveries' => $totalDeliveries,
            'weekly_sales_chart' => [
                'labels' => $weeklyLabels,
                'data' => $weeklyLabels->map(fn (string $day): float => (float) $weeklyRevenue
                    ->get($day, collect())
                    ->sum('total_price')),
            ],
            'top_meals_chart' => [
                'labels' => $topMeals->pluck('name'),
                'data' => $topMeals->pluck('sold'),
            ],
            'meal_mix_chart' => [
                'labels' => $mealCategoryCounts->keys()->values(),
                'data' => $mealCategoryCounts->values(),
            ],
        ];

        return view('admin.analytics.index', compact('analytics'));
    }
}
