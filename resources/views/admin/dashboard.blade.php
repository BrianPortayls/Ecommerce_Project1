@php
    $stats = [
        ['label' => 'Orders', 'value' => '1,248', 'change' => '+12.4%', 'icon' => 'fa-receipt', 'tone' => 'amber'],
        ['label' => 'Revenue', 'value' => '$28,430', 'change' => '+8.2%', 'icon' => 'fa-wallet', 'tone' => 'green'],
        ['label' => 'Active menu', 'value' => '36', 'change' => '+3 meals', 'icon' => 'fa-bowl-food', 'tone' => 'sky'],
        ['label' => 'Delivery rate', 'value' => '94%', 'change' => '+4.1%', 'icon' => 'fa-motorcycle', 'tone' => 'rose'],
    ];

    $orders = [
        ['id' => '#MC-1048', 'customer' => 'Maria Santos', 'meal' => 'Tapsilog Express', 'amount' => '$18.50', 'method' => 'Delivery', 'status' => 'Preparing'],
        ['id' => '#MC-1047', 'customer' => 'Jay Cruz', 'meal' => 'Porksilog Bistro', 'amount' => '$24.00', 'method' => 'Pickup', 'status' => 'Ready'],
        ['id' => '#MC-1046', 'customer' => 'Ana Reyes', 'meal' => 'Cornsilog Kitchen', 'amount' => '$12.75', 'method' => 'Delivery', 'status' => 'Completed'],
        ['id' => '#MC-1045', 'customer' => 'Brian Lee', 'meal' => 'Chicken Rice Bowl', 'amount' => '$16.20', 'method' => 'Delivery', 'status' => 'New order'],
        ['id' => '#MC-1044', 'customer' => 'Kim Tan', 'meal' => 'Sizzling Pork Plate', 'amount' => '$21.40', 'method' => 'Pickup', 'status' => 'Preparing'],
    ];

    $topMeals = [
        ['name' => 'Tapsilog Express', 'sold' => 454, 'revenue' => '$7,260', 'rating' => '5/5', 'status' => 'Available', 'icon' => 'fa-egg'],
        ['name' => 'Porksilog Bistro', 'sold' => 392, 'revenue' => '$6,510', 'rating' => '4.9/5', 'status' => 'Available', 'icon' => 'fa-bacon'],
        ['name' => 'Cornsilog Kitchen', 'sold' => 284, 'revenue' => '$4,830', 'rating' => '4.8/5', 'status' => 'Low stock', 'icon' => 'fa-bowl-rice'],
        ['name' => 'Chicken Rice Bowl', 'sold' => 246, 'revenue' => '$3,940', 'rating' => '4.7/5', 'status' => 'Available', 'icon' => 'fa-drumstick-bite'],
        ['name' => 'Sizzling Pork Plate', 'sold' => 198, 'revenue' => '$3,560', 'rating' => '4.6/5', 'status' => 'Low stock', 'icon' => 'fa-fire-burner'],
    ];

    $locations = [
        ['name' => 'Downtown', 'value' => '$11,420', 'width' => 88, 'tone' => 'green'],
        ['name' => 'Northside', 'value' => '$8,756', 'width' => 68, 'tone' => 'sky'],
        ['name' => 'University', 'value' => '$6,184', 'width' => 54, 'tone' => 'amber'],
        ['name' => 'Riverside', 'value' => '$4,920', 'width' => 42, 'tone' => 'rose'],
    ];
@endphp

@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('kicker', 'Food operations')
@section('heading', 'Micaller kitchen dashboard')

@section('content')
    <div class="food-dashboard">
        <section class="dashboard-hero">
            <div class="hero-card">
                <p class="hero-eyebrow">Fresh queue</p>
                <h2>Hello Admin, lunch rush is warming up</h2>
                <p>Track orders, menu performance, delivery pressure, and store revenue from one food-first dashboard.</p>
                <a href="{{ route('admin.orders.index') }}" class="admin-primary-button">View orders</a>
            </div>

            <aside class="ideas-card">
                <div class="ideas-nav">
                    <p>Ideas for You</p>
                    <span><i class="fa-solid fa-chevron-left"></i></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                </div>
                <h3>Promote the best lunch combo</h3>
                <p>Feature Tapsilog Express with iced tea today. It is leading sales and pairs well with delivery bundles.</p>
                <a href="{{ route('admin.menu-items.index') }}">Review menu</a>
            </aside>
        </section>

        <section class="stats-grid dashboard-stats" aria-label="Store overview">
            @foreach ($stats as $stat)
                <article class="stat-card metric-card metric-{{ $stat['tone'] }}">
                    <div class="metric-head">
                        <span class="stat-icon"><i class="fa-solid {{ $stat['icon'] }}"></i></span>
                        <p>{{ $stat['label'] }}</p>
                    </div>
                    <div>
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['change'] }} <i class="fa-solid fa-arrow-trend-up"></i></span>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="analytics-grid">
            <section class="dashboard-card revenue-card">
                <div class="panel-header">
                    <div>
                        <p class="admin-kicker">Revenue</p>
                        <h2>Weekly food sales</h2>
                    </div>
                    <span class="admin-role-pill">This week</span>
                </div>

                <div class="revenue-summary">
                    <div>
                        <span class="legend-dot green"></span>
                        <p>Total income</p>
                        <strong>$28,430</strong>
                    </div>
                    <div>
                        <span class="legend-dot amber"></span>
                        <p>Kitchen cost</p>
                        <strong>$9,814</strong>
                    </div>
                </div>

                <div class="line-chart" aria-label="Revenue chart from Monday to Sunday">
                    <svg viewBox="0 0 720 260" role="img" aria-labelledby="revenueChartTitle">
                        <title id="revenueChartTitle">Food revenue rises through the week and peaks on Saturday</title>
                        <defs>
                            <linearGradient id="revenueFill" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#09b981" stop-opacity="0.45" />
                                <stop offset="100%" stop-color="#09b981" stop-opacity="0.02" />
                            </linearGradient>
                        </defs>
                        <path class="chart-grid" d="M40 40 H700 M40 90 H700 M40 140 H700 M40 190 H700 M40 240 H700" />
                        <path class="chart-area" d="M40 208 C120 205 138 172 208 178 C288 186 303 132 382 138 C462 143 478 78 558 70 C620 64 650 88 700 82 L700 240 L40 240 Z" />
                        <path class="chart-line" d="M40 208 C120 205 138 172 208 178 C288 186 303 132 382 138 C462 143 478 78 558 70 C620 64 650 88 700 82" />
                        <g class="chart-points">
                            <circle cx="40" cy="208" r="5" />
                            <circle cx="208" cy="178" r="5" />
                            <circle cx="382" cy="138" r="5" />
                            <circle cx="558" cy="70" r="5" />
                            <circle cx="700" cy="82" r="5" />
                        </g>
                    </svg>
                    <div class="chart-labels">
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                        <span>Sun</span>
                    </div>
                </div>
            </section>

            <aside class="dashboard-card meal-mix-card">
                <p class="admin-kicker">Product sales</p>
                <h2>Meal mix</h2>
                <div class="donut-chart" role="img" aria-label="Meal mix: silog meals 38 percent, rice bowls 29 percent, drinks 24 percent, sides 9 percent">
                    <span>1,248<br><small>orders</small></span>
                </div>
                <div class="mix-list">
                    <div><span class="legend-dot green"></span>Silog meals <strong>38.1%</strong></div>
                    <div><span class="legend-dot amber"></span>Rice bowls <strong>28.6%</strong></div>
                    <div><span class="legend-dot sky"></span>Drinks <strong>23.8%</strong></div>
                    <div><span class="legend-dot rose"></span>Sides <strong>9.5%</strong></div>
                </div>
            </aside>
        </div>

        <div class="operations-grid">
            <section class="dashboard-card orders-card">
                <div class="panel-header">
                    <div>
                        <p class="admin-kicker">Live queue</p>
                        <h2>Recent food orders</h2>
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
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Meal</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order['id'] }}</td>
                                    <td>{{ $order['customer'] }}</td>
                                    <td>{{ $order['meal'] }}</td>
                                    <td>{{ $order['amount'] }}</td>
                                    <td>{{ $order['method'] }}</td>
                                    <td><span class="status-pill status-{{ Str::slug($order['status']) }}">{{ $order['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="dashboard-card location-card">
                <p class="admin-kicker">Delivery zones</p>
                <h2>Revenue by location</h2>
                <div class="zone-map">
                    <span class="zone-pin zone-one"></span>
                    <span class="zone-pin zone-two"></span>
                    <span class="zone-pin zone-three"></span>
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="location-list">
                    @foreach ($locations as $location)
                        <div class="location-row">
                            <div>
                                <span>{{ $location['name'] }}</span>
                                <strong>{{ $location['value'] }}</strong>
                            </div>
                            <span class="location-bar"><i class="{{ $location['tone'] }}" style="width: {{ $location['width'] }}%"></i></span>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>

        <section class="dashboard-card top-meals-card">
            <p class="admin-kicker">Top selling products</p>
            <h2>Best performing meals</h2>
            <div class="top-meals-table-wrap">
                <table class="orders-table top-meals-table">
                    <thead>
                        <tr>
                            <th>Meal</th>
                            <th>Sale</th>
                            <th>Revenue</th>
                            <th>Rating</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topMeals as $meal)
                            <tr>
                                <td>
                                    <span class="meal-avatar"><i class="fa-solid {{ $meal['icon'] }}"></i></span>
                                    {{ $meal['name'] }}
                                </td>
                                <td>{{ $meal['sold'] }}</td>
                                <td>{{ $meal['revenue'] }}</td>
                                <td><i class="fa-solid fa-star rating-star"></i> {{ $meal['rating'] }}</td>
                                <td><span class="stock-pill stock-{{ Str::slug($meal['status']) }}">{{ $meal['status'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
