@php
    $stats = [
        ['label' => 'Today orders', 'value' => '48', 'change' => '+12%', 'icon' => 'fa-receipt'],
        ['label' => 'Revenue', 'value' => '$2,840', 'change' => '+8%', 'icon' => 'fa-wallet'],
        ['label' => 'Active menu', 'value' => '36', 'change' => '+3 new', 'icon' => 'fa-bowl-food'],
        ['label' => 'Pending delivery', 'value' => '14', 'change' => 'Live', 'icon' => 'fa-motorcycle'],
    ];

    $orders = [
        ['customer' => 'Maria Santos', 'order' => '#MC-1048', 'items' => 'Tapsilog, Iced Tea', 'total' => '$18.50', 'status' => 'Preparing', 'time' => '10 min'],
        ['customer' => 'Jay Cruz', 'order' => '#MC-1047', 'items' => 'Porksilog, Pancit', 'total' => '$24.00', 'status' => 'Out for delivery', 'time' => '18 min'],
        ['customer' => 'Ana Reyes', 'order' => '#MC-1046', 'items' => 'Cornsilog Bowl', 'total' => '$12.75', 'status' => 'Completed', 'time' => 'Done'],
        ['customer' => 'Brian Lee', 'order' => '#MC-1045', 'items' => 'Chicken Rice Bowl', 'total' => '$16.20', 'status' => 'New order', 'time' => 'Now'],
        ['customer' => 'Kim Tan', 'order' => '#MC-1044', 'items' => 'Sizzling Pork, Soda', 'total' => '$21.40', 'status' => 'Preparing', 'time' => '12 min'],
    ];

    $popularItems = [
        ['name' => 'Tapsilog Express', 'sold' => 142, 'color' => 'green'],
        ['name' => 'Porksilog Bistro', 'sold' => 118, 'color' => 'amber'],
        ['name' => 'Cornsilog Kitchen', 'sold' => 96, 'color' => 'rose'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin Dashboard - {{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ filemtime(public_path('css/admin/dashboard.css')) }}">
    </head>
    <body>
        <main class="admin-shell">
            <aside class="admin-sidebar" aria-label="Admin navigation">
                <a href="{{ route('home') }}" class="admin-brand">
                    <span class="brand-mark"><i class="fa-solid fa-utensils"></i></span>
                    <span>{{ config('app.name', 'Micaller') }}</span>
                </a>

                <nav class="admin-nav">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link is-active">
                        <i class="fa-solid fa-chart-line"></i>
                        Dashboard
                    </a>
                    <a href="#" class="admin-nav-link">
                        <i class="fa-solid fa-receipt"></i>
                        Orders
                    </a>
                    <a href="#" class="admin-nav-link">
                        <i class="fa-solid fa-bowl-food"></i>
                        Menu items
                    </a>
                    <a href="#" class="admin-nav-link">
                        <i class="fa-solid fa-users"></i>
                        Customers
                    </a>
                    <a href="{{ route('admin.managers.create') }}" class="admin-nav-link">
                        <i class="fa-solid fa-user-tie"></i>
                        Managers
                    </a>
                    <a href="#" class="admin-nav-link">
                        <i class="fa-solid fa-motorcycle"></i>
                        Deliveries
                    </a>
                    <a href="#" class="admin-nav-link">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </a>
                </nav>

                <div class="sidebar-note">
                    <i class="fa-solid fa-fire"></i>
                    <strong>Lunch rush</strong>
                    <span>Orders are 18% higher than yesterday.</span>
                </div>
            </aside>

            <section class="admin-main">
                <header class="admin-topbar">
                    <div>
                        <p class="admin-kicker">Admin dashboard</p>
                        <h1>Manage today's food orders</h1>
                    </div>

                    <div class="admin-actions">
                        <span class="admin-role-pill">Admin</span>
                        <a href="{{ route('home') }}" class="admin-soft-button">View store</a>
                        <button type="button" class="admin-primary-button">
                            <i class="fa-solid fa-plus"></i>
                            Add menu item
                        </button>
                        <a href="{{ route('admin.managers.create') }}" class="admin-soft-button">Create manager</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="admin-logout">Log out</button>
                        </form>
                    </div>
                </header>

                <section class="stats-grid" aria-label="Store overview">
                    @foreach ($stats as $stat)
                        <article class="stat-card">
                            <span class="stat-icon"><i class="fa-solid {{ $stat['icon'] }}"></i></span>
                            <p>{{ $stat['label'] }}</p>
                            <div>
                                <strong>{{ $stat['value'] }}</strong>
                                <span>{{ $stat['change'] }}</span>
                            </div>
                        </article>
                    @endforeach
                </section>

                <div class="workspace-grid">
                    <section class="orders-panel">
                        <div class="panel-header">
                            <div>
                                <p class="admin-kicker">Live queue</p>
                                <h2>Recent orders</h2>
                            </div>
                            <label class="admin-search">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="search" placeholder="Search orders">
                            </label>
                        </div>

                        <div class="orders-table-wrap">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Order</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>ETA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order['customer'] }}</td>
                                            <td>{{ $order['order'] }}</td>
                                            <td>{{ $order['items'] }}</td>
                                            <td>{{ $order['total'] }}</td>
                                            <td>
                                                <span class="status-pill status-{{ Str::slug($order['status']) }}">{{ $order['status'] }}</span>
                                            </td>
                                            <td>{{ $order['time'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <aside class="side-panel">
                        <section class="delivery-card">
                            <p class="admin-kicker">Delivery map</p>
                            <h2>14 riders active</h2>
                            <div class="delivery-visual">
                                <span class="pin pin-one"></span>
                                <span class="pin pin-two"></span>
                                <span class="pin pin-three"></span>
                                <i class="fa-solid fa-motorcycle"></i>
                            </div>
                            <p class="muted-text">Average delivery time is 24 minutes today.</p>
                        </section>

                        <section class="popular-card">
                            <div class="panel-header compact">
                                <div>
                                    <p class="admin-kicker">Top sellers</p>
                                    <h2>Popular meals</h2>
                                </div>
                            </div>

                            <div class="popular-list">
                                @foreach ($popularItems as $item)
                                    <div class="popular-item">
                                        <span class="meal-dot {{ $item['color'] }}"></span>
                                        <div>
                                            <strong>{{ $item['name'] }}</strong>
                                            <p>{{ $item['sold'] }} sold this week</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </aside>
                </div>
            </section>
        </main>
    </body>
</html>
