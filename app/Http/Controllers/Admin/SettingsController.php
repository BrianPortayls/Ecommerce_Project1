<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
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
        $totalOrders = Order::query()->count();
        $totalRevenue = Order::query()->sum('total_price');
        $totalDeliveries = DB::table('deliveries')->count();

        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $weeklyRevenue = Order::query()
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->get(['total_price', 'created_at'])
            ->groupBy(fn (Order $order): string => Carbon::parse($order->created_at)->format('D'));

        $weeklyLabels = collect(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);

        $mealCategoryCounts = OrderItem::query()
            ->selectRaw("coalesce(category, 'Uncategorized') as category, sum(quantity) as aggregate")
            ->groupBy('category')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'category');

        $topMeals = OrderItem::query()
            ->selectRaw('name, sum(quantity) as sold')
            ->groupBy('name')
            ->orderByDesc('sold')
            ->limit(8)
            ->get();

        $analytics = [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_customers' => User::query()->where('role', User::ROLE_CUSTOMER)->count(),
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
