@extends('layouts.admin')

@section('title', 'Analytics')
@section('kicker', 'Admin analytics')
@section('heading', 'Store performance')

@section('content')
    <section class="stats-grid" aria-label="Store analytics">
        <article class="stat-card">
            <span class="stat-icon"><i class="fa-solid fa-receipt"></i></span>
            <p>Total orders</p>
            <div>
                <strong>{{ $analytics['total_orders'] }}</strong>
            </div>
        </article>
        <article class="stat-card">
            <span class="stat-icon"><i class="fa-solid fa-wallet"></i></span>
            <p>Total revenue</p>
            <div>
                <strong>${{ number_format($analytics['total_revenue'], 2) }}</strong>
            </div>
        </article>
        <article class="stat-card">
            <span class="stat-icon"><i class="fa-solid fa-users"></i></span>
            <p>Total customers</p>
            <div>
                <strong>{{ $analytics['total_customers'] }}</strong>
            </div>
        </article>
        <article class="stat-card">
            <span class="stat-icon"><i class="fa-solid fa-motorcycle"></i></span>
            <p>Total deliveries</p>
            <div>
                <strong>{{ $analytics['total_deliveries'] }}</strong>
            </div>
        </article>
    </section>

    <div class="analytics-grid admin-analytics-charts">
        <section class="dashboard-card chart-card">
            <div class="panel-header">
                <div>
                    <p class="admin-kicker">Revenue</p>
                    <h2>Weekly sales</h2>
                </div>
                <span class="admin-role-pill">Live data</span>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="weeklySalesChart"></canvas>
            </div>
        </section>

        <aside class="dashboard-card chart-card">
            <div class="panel-header">
                <div>
                    <p class="admin-kicker">Menu</p>
                    <h2>Meal mix</h2>
                </div>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="mealMixChart"></canvas>
            </div>
        </aside>
    </div>

    <section class="dashboard-card chart-card revenue-analytics-card">
        <div class="panel-header">
            <div>
                <p class="admin-kicker">Popular meals</p>
                <h2>Top selling meals</h2>
            </div>
        </div>
        <div class="chart-canvas-wrap wide">
            <canvas id="topMealsChart"></canvas>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const analyticsCharts = {{ Illuminate\Support\Js::from([
            'weeklySales' => $analytics['weekly_sales_chart'],
            'topMeals' => $analytics['top_meals_chart'],
            'mealMix' => $analytics['meal_mix_chart'],
        ]) }};

        let adminAnalyticsChartsRendered = false;

        function renderAdminAnalyticsCharts() {
            if (adminAnalyticsChartsRendered || !window.Chart) {
                return;
            }

            adminAnalyticsChartsRendered = true;

            new Chart(document.getElementById('weeklySalesChart'), {
                type: 'line',
                data: {
                    labels: analyticsCharts.weeklySales.labels,
                    datasets: [{
                        label: 'Sales',
                        data: analyticsCharts.weeklySales.data,
                        borderColor: '#09b981',
                        backgroundColor: 'rgba(9, 185, 129, 0.16)',
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#09b981',
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                },
            });

            new Chart(document.getElementById('mealMixChart'), {
                type: 'doughnut',
                data: {
                    labels: analyticsCharts.mealMix.labels,
                    datasets: [{
                        label: 'Meal mix',
                        data: analyticsCharts.mealMix.data,
                        backgroundColor: ['#12b8d7', '#09b981', '#f59e0b', '#ff6047'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                },
            });

            new Chart(document.getElementById('topMealsChart'), {
                type: 'bar',
                data: {
                    labels: analyticsCharts.topMeals.labels,
                    datasets: [{
                        label: 'Sold',
                        data: analyticsCharts.topMeals.data,
                        backgroundColor: '#09b981',
                        borderRadius: 8,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                },
            });
        }

        document.addEventListener('DOMContentLoaded', renderAdminAnalyticsCharts);
        document.addEventListener('chartjs:ready', renderAdminAnalyticsCharts);
    </script>
@endpush
