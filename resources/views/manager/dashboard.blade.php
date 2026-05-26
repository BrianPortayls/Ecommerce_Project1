@extends('layouts.manager')

@section('title', 'Staff Dashboard')
@section('kicker', 'Staff dashboard')
@section('heading', "Today's orders & menu")

@php
    $stats = [
        ['label' => 'New orders',  'value' => '12', 'change' => 'Incoming',  'icon' => 'fa-bell'],
        ['label' => 'Preparing',   'value' => '7',  'change' => 'In kitchen','icon' => 'fa-fire-burner'],
        ['label' => 'Completed',   'value' => '29', 'change' => 'Today',     'icon' => 'fa-circle-check'],
        ['label' => 'Active menu', 'value' => '24', 'change' => 'Items',     'icon' => 'fa-bowl-food'],
    ];

    $orders = [
        ['customer' => 'Maria Santos', 'order' => '#MC-1048', 'items' => 'Tapsilog, Iced Tea',   'total' => '₱185', 'status' => 'New order',        'time' => 'Now'],
        ['customer' => 'Jay Cruz',     'order' => '#MC-1047', 'items' => 'Porksilog, Pancit',    'total' => '₱240', 'status' => 'Preparing',        'time' => '10 min'],
        ['customer' => 'Ana Reyes',    'order' => '#MC-1046', 'items' => 'Cornsilog Bowl',       'total' => '₱120', 'status' => 'Preparing',        'time' => '15 min'],
        ['customer' => 'Brian Lee',    'order' => '#MC-1045', 'items' => 'Chicken Rice Bowl',    'total' => '₱155', 'status' => 'Out for delivery', 'time' => '18 min'],
        ['customer' => 'Kim Tan',      'order' => '#MC-1044', 'items' => 'Sizzling Pork, Soda', 'total' => '₱210', 'status' => 'Completed',        'time' => 'Done'],
    ];

    $menuItems = [
        ['name' => 'Tapsilog Supreme', 'category' => 'Silog Meals', 'price' => '₱185', 'status' => 'Available'],
        ['name' => 'Sizzling Sisig',   'category' => 'Sizzling',    'price' => '₱210', 'status' => 'Available'],
        ['name' => 'Chicken Inasal',   'category' => 'Chicken',     'price' => '₱175', 'status' => 'Available'],
        ['name' => 'Pancit Canton',    'category' => 'Pancit',      'price' => '₱120', 'status' => 'Sold out'],
        ['name' => 'Cornsilog Bowl',   'category' => 'Silog Meals', 'price' => '₱155', 'status' => 'Available'],
    ];
@endphp

@section('content')

    <section class="stats-grid" aria-label="Today overview">
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
                    <h2>Incoming orders</h2>
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
                            <th>Action</th>
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
                                    <span class="status-pill status-{{ Str::slug($order['status']) }}">
                                        {{ $order['status'] }}
                                    </span>
                                </td>
                                <td>{{ $order['time'] }}</td>
                                <td>
                                    @if ($order['status'] === 'New order')
                                        <button class="admin-primary-button" style="padding: 4px 12px; font-size: 0.78rem; min-height: 30px;">Accept</button>
                                    @elseif ($order['status'] === 'Preparing')
                                        <button class="admin-soft-button" style="padding: 4px 12px; font-size: 0.78rem; min-height: 30px;">Mark done</button>
                                    @else
                                        <span style="color: var(--muted); font-size: 0.82rem;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="side-panel">
            <section class="popular-card">
                <div class="panel-header compact">
                    <div>
                        <p class="admin-kicker">Stock control</p>
                        <h2>Menu items</h2>
                    </div>
                </div>
                <div class="popular-list">
                    @foreach ($menuItems as $item)
                        <div class="popular-item" style="justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span class="meal-dot {{ $item['status'] === 'Available' ? 'green' : 'rose' }}"></span>
                                <div>
                                    <strong>{{ $item['name'] }}</strong>
                                    <p>{{ $item['category'] }} · {{ $item['price'] }}</p>
                                </div>
                            </div>
                            <span class="status-pill {{ $item['status'] === 'Available' ? 'status-completed' : 'status-new-order' }}"
                                  style="font-size: 0.72rem;">
                                {{ $item['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </section>
        </aside>

    </div>

@endsection
