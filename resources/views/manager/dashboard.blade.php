@extends('layouts.manager')

@section('title', 'Manager Dashboard')
@section('kicker', 'Manager Dashboard')
@section('heading', "Today's orders & menu")

@section('content')
    @if (session('status'))
        <div class="admin-success">{{ session('status') }}</div>
    @endif

    <section class="stats-grid" aria-label="Today overview">
        @foreach ($stats as $stat)
            <article class="stat-card">
                <span class="stat-icon"><i class="fa-solid {{ $stat['icon'] }}"></i></span>
                <p>{{ $stat['label'] }}</p>
                <div>
                    <strong>{{ number_format($stat['value']) }}</strong>
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
                            <th>Placed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->customer?->name ?? 'Deleted customer' }}</td>
                                <td>#{{ $order->order_number ?: 'MC-'.$order->id }}</td>
                                <td>{{ $order->items->map(fn ($item) => $item->quantity.'x '.$item->name)->join(', ') ?: 'No items' }}</td>
                                <td>₱{{ number_format((float) $order->total_price, 2) }}</td>
                                <td>
                                    <span class="status-pill status-{{ Str::slug($order->status) }}">
                                        {{ Str::headline($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <form method="POST" action="{{ route('manager.orders.status', $order) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="@if ($order->status === App\Models\Order::STATUS_PENDING){{ App\Models\Order::STATUS_PREPARING }}@elseif ($order->status === App\Models\Order::STATUS_PREPARING){{ App\Models\Order::STATUS_READY }}@else{{ App\Models\Order::STATUS_COMPLETED }}@endif">
                                        <button class="{{ $order->status === App\Models\Order::STATUS_PENDING ? 'admin-primary-button' : 'admin-soft-button' }}" style="padding: 4px 12px; font-size: 0.78rem; min-height: 30px;">
                                            @if ($order->status === App\Models\Order::STATUS_PENDING)
                                                Accept
                                            @elseif ($order->status === App\Models\Order::STATUS_PREPARING)
                                                Mark ready
                                            @else
                                                Complete
                                            @endif
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No active orders in the queue.</td>
                            </tr>
                        @endforelse
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
                    @forelse ($menuItems as $item)
                        <div class="popular-item" style="justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span class="meal-dot {{ $item->is_available ? 'green' : 'rose' }}"></span>
                                <div>
                                    <strong>{{ $item->name }}</strong>
                                    <p>{{ $item->category }} · ₱{{ number_format((float) $item->price, 2) }}</p>
                                </div>
                            </div>
                            <span class="status-pill {{ $item->is_available ? 'status-completed' : 'status-new-order' }}" style="font-size: 0.72rem;">
                                {{ $item->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fa-solid fa-bowl-food"></i>
                            <p>No menu items have been added yet.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </aside>
    </div>
@endsection
