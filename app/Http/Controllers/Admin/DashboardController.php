<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $now = now();
        $weekStart = $now->copy()->startOfWeek();
        $weekEnd = $now->copy()->endOfWeek();
        $previousWeekStart = $weekStart->copy()->subWeek();
        $previousWeekEnd = $weekEnd->copy()->subWeek();

        $ordersThisWeek = Order::query()->whereBetween('created_at', [$weekStart, $weekEnd]);
        $ordersLastWeek = Order::query()->whereBetween('created_at', [$previousWeekStart, $previousWeekEnd]);

        $totalOrders = (clone $ordersThisWeek)->count();
        $previousTotalOrders = (clone $ordersLastWeek)->count();
        $totalRevenue = (float) (clone $ordersThisWeek)->sum('total_price');
        $previousRevenue = (float) (clone $ordersLastWeek)->sum('total_price');
        $activeMenuItems = MenuItem::query()->where('is_available', true)->count();
        $totalDeliveries = Order::query()
            ->where('fulfillment_method', Order::FULFILLMENT_DELIVERY)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();
        $completedDeliveries = Delivery::query()
            ->where('status', Delivery::STATUS_DELIVERED)
            ->whereHas('order', fn ($query) => $query->whereBetween('created_at', [$weekStart, $weekEnd]))
            ->count();

        $weeklyOrders = Order::query()
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->get(['total_price', 'created_at'])
            ->groupBy(fn (Order $order): string => $order->created_at->format('D'));

        $weeklyLabels = collect(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
        $weeklySales = [
            'labels' => $weeklyLabels,
            'data' => $weeklyLabels->map(fn (string $day): float => (float) $weeklyOrders->get($day, collect())->sum('total_price')),
        ];

        $topMeals = OrderItem::query()
            ->selectRaw('name, category, sum(quantity) as sold, sum(line_total) as revenue')
            ->groupBy('name', 'category')
            ->orderByDesc('sold')
            ->limit(5)
            ->get();

        $mealMixRows = OrderItem::query()
            ->selectRaw("coalesce(category, 'Uncategorized') as category, sum(quantity) as sold")
            ->groupBy('category')
            ->orderByDesc('sold')
            ->limit(6)
            ->get();
        $mealMixTotal = max(1, (int) $mealMixRows->sum('sold'));
        $mealMix = $mealMixRows->map(fn (OrderItem $row): array => [
            'category' => $row->category ?: 'Uncategorized',
            'percentage' => round(((int) $row->sold / $mealMixTotal) * 100, 1),
            'sold' => (int) $row->sold,
        ]);

        $recentOrders = Order::query()
            ->with(['customer:id,name,email', 'items:id,order_id,name'])
            ->latest()
            ->limit(8)
            ->get();

        $locationRows = Order::query()
            ->selectRaw("coalesce(delivery_location, 'Pickup') as delivery_location, sum(total_price) as revenue")
            ->groupBy('delivery_location')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();
        $topLocationRevenue = max(1, (float) $locationRows->max('revenue'));
        $locations = $locationRows->map(fn (Order $order): array => [
            'name' => $order->delivery_location ?: 'Pickup',
            'value' => (float) $order->revenue,
            'width' => (int) round(((float) $order->revenue / $topLocationRevenue) * 100),
        ]);

        return view('admin.dashboard', [
            'stats' => [
                [
                    'label' => 'Total Orders',
                    'value' => number_format($totalOrders),
                    'change' => $this->formatChange($totalOrders, $previousTotalOrders),
                    'icon' => 'fa-receipt',
                    'tone' => 'amber',
                ],
                [
                    'label' => 'Revenue',
                    'value' => $this->money($totalRevenue),
                    'change' => $this->formatChange($totalRevenue, $previousRevenue),
                    'icon' => 'fa-wallet',
                    'tone' => 'green',
                ],
                [
                    'label' => 'Active Menu',
                    'value' => number_format($activeMenuItems),
                    'change' => 'available',
                    'icon' => 'fa-bowl-food',
                    'tone' => 'sky',
                ],
                [
                    'label' => 'Delivery Rate',
                    'value' => $totalDeliveries === 0 ? '0%' : round(($completedDeliveries / $totalDeliveries) * 100).'%',
                    'change' => number_format($completedDeliveries).' delivered',
                    'icon' => 'fa-motorcycle',
                    'tone' => 'rose',
                ],
            ],
            'weeklySales' => $weeklySales,
            'totalRevenue' => $totalRevenue,
            'estimatedKitchenCost' => $totalRevenue * 0.35,
            'recentOrders' => $recentOrders,
            'topMeals' => $topMeals,
            'locations' => $locations,
            'mealMix' => $mealMix,
            'totalOrders' => $totalOrders,
        ]);
    }

    protected function formatChange(int|float $current, int|float $previous): string
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0.0 ? 'new' : '0%';
        }

        $change = (($current - $previous) / $previous) * 100;

        return ($change >= 0 ? '+' : '').round($change, 1).'%';
    }

    protected function money(float $amount): string
    {
        return '₱'.number_format($amount, 2);
    }
}
