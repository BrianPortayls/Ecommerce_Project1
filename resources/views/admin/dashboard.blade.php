@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('kicker', 'Food operations')
@section('heading', 'Micaller kitchen dashboard')

@section('content')
    <div class="food-dashboard">
        <section class="dashboard-hero">
            <div class="hero-card">
                <p class="hero-eyebrow">Fresh queue</p>
                <h2>Hello {{ auth()->user()->name }}, the kitchen is live</h2>
                <p>Track orders, menu performance, delivery pressure, and store revenue from live database activity.</p>
                <a href="{{ route('admin.orders.index') }}" class="admin-primary-button">View orders</a>
            </div>

            <aside class="ideas-card">
                <div class="ideas-nav">
                    <p>Ideas for You</p>
                    <span><i class="fa-solid fa-chevron-left"></i></span>
                    <span><i class="fa-solid fa-chevron-right"></i></span>
                </div>
                <h3>{{ $topMeals->first()?->name ? 'Promote '.$topMeals->first()->name : 'Build your first sales insight' }}</h3>
                <p>{{ $topMeals->first()?->name ? 'This meal is currently leading sold quantity in your orders.' : 'Order item data will appear here as customers place orders.' }}</p>
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
                        <strong>₱{{ number_format($totalRevenue, 2) }}</strong>
                    </div>
                    <div>
                        <span class="legend-dot amber"></span>
                        <p>Kitchen cost</p>
                        <strong>₱{{ number_format($estimatedKitchenCost, 2) }}</strong>
                    </div>
                </div>

                <div class="chart-canvas-wrap">
                    <canvas id="dashboardWeeklySalesChart" aria-label="Weekly sales chart"></canvas>
                </div>
            </section>

            <aside class="dashboard-card meal-mix-card">
                <p class="admin-kicker">Product sales</p>
                <h2>Meal mix</h2>
                <div class="chart-canvas-wrap">
                    <canvas id="dashboardMealMixChart" aria-label="Meal mix chart"></canvas>
                </div>
                <div class="mix-list">
                    @forelse ($mealMix as $mix)
                        <div><span class="legend-dot {{ ['green', 'amber', 'sky', 'rose'][$loop->index % 4] }}"></span>{{ $mix['category'] }} <strong>{{ $mix['percentage'] }}%</strong></div>
                    @empty
                        <div>No order item mix yet <strong>0%</strong></div>
                    @endforelse
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
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number ?: 'MC-'.$order->id }}</td>
                                    <td>{{ $order->customer?->name ?? 'Deleted customer' }}</td>
                                    <td>{{ $order->items->pluck('name')->take(2)->join(', ') ?: 'No items' }}</td>
                                    <td>₱{{ number_format((float) $order->total_price, 2) }}</td>
                                    <td>{{ ucfirst($order->fulfillment_method) }}</td>
                                    <td><span class="status-pill status-{{ Str::slug($order->status) }}">{{ Str::headline($order->status) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No orders yet.</td>
                                </tr>
                            @endforelse
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
                    @forelse ($locations as $location)
                        <div class="location-row">
                            <div>
                                <span>{{ $location['name'] }}</span>
                                <strong>₱{{ number_format($location['value'], 2) }}</strong>
                            </div>
                            <span class="location-bar"><i class="{{ ['green', 'sky', 'amber', 'rose'][$loop->index % 4] }}" style="width: {{ $location['width'] }}%"></i></span>
                        </div>
                    @empty
                        <p class="muted-text">No location revenue yet.</p>
                    @endforelse
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
                        @forelse ($topMeals as $meal)
                            <tr>
                                <td>
                                    <span class="meal-avatar"><i class="fa-solid fa-bowl-food"></i></span>
                                    {{ $meal->name }}
                                </td>
                                <td>{{ number_format((int) $meal->sold) }}</td>
                                <td>₱{{ number_format((float) $meal->revenue, 2) }}</td>
                                <td>{{ $meal->category ?: 'Uncategorized' }}</td>
                                <td><span class="stock-pill">Tracked</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No meal sales yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const dashboardCharts = {{ Illuminate\Support\Js::from([
            'weeklySales' => $weeklySales,
            'mealMix' => [
                'labels' => $mealMix->pluck('category'),
                'data' => $mealMix->pluck('sold'),
            ],
        ]) }};

        let dashboardChartsRendered = false;

        function renderDashboardCharts() {
            if (dashboardChartsRendered || !window.Chart) {
                return;
            }

            dashboardChartsRendered = true;

            new Chart(document.getElementById('dashboardWeeklySalesChart'), {
                type: 'line',
                data: {
                    labels: dashboardCharts.weeklySales.labels,
                    datasets: [{
                        label: 'Sales',
                        data: dashboardCharts.weeklySales.data,
                        borderColor: '#09b981',
                        backgroundColor: 'rgba(9, 185, 129, 0.16)',
                        fill: true,
                        tension: 0.35,
                    }],
                },
                options: { responsive: true, maintainAspectRatio: false },
            });

            new Chart(document.getElementById('dashboardMealMixChart'), {
                type: 'doughnut',
                data: {
                    labels: dashboardCharts.mealMix.labels,
                    datasets: [{
                        data: dashboardCharts.mealMix.data,
                        backgroundColor: ['#09b981', '#f59e0b', '#12b8d7', '#ff6047', '#7c3aed', '#334155'],
                        borderWidth: 0,
                    }],
                },
                options: { responsive: true, maintainAspectRatio: false },
            });
        }

        document.addEventListener('DOMContentLoaded', renderDashboardCharts);
        document.addEventListener('chartjs:ready', renderDashboardCharts);
    </script>
@endpush
