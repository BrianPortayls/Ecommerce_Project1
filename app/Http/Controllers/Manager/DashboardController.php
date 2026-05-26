<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $today = now();

        return view('manager.dashboard', [
            'stats' => [
                ['label' => 'New orders', 'value' => Order::query()->whereDate('created_at', $today)->where('status', Order::STATUS_PENDING)->count(), 'change' => 'Incoming', 'icon' => 'fa-bell'],
                ['label' => 'Preparing', 'value' => Order::query()->whereDate('created_at', $today)->where('status', Order::STATUS_PREPARING)->count(), 'change' => 'In kitchen', 'icon' => 'fa-fire-burner'],
                ['label' => 'Completed', 'value' => Order::query()->whereDate('created_at', $today)->where('status', Order::STATUS_COMPLETED)->count(), 'change' => 'Today', 'icon' => 'fa-circle-check'],
                ['label' => 'Active menu', 'value' => MenuItem::query()->where('is_available', true)->count(), 'change' => 'Items', 'icon' => 'fa-bowl-food'],
            ],
            'orders' => Order::query()
                ->with(['customer:id,name,email', 'items:id,order_id,name,quantity'])
                ->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_PREPARING, Order::STATUS_READY])
                ->latest()
                ->limit(8)
                ->get(),
            'menuItems' => MenuItem::query()
                ->orderByDesc('is_available')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->limit(8)
                ->get(),
        ]);
    }
}
