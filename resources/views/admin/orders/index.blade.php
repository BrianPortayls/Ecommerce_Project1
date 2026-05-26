@extends('layouts.admin')

@section('title', 'Orders')
@section('kicker', 'Order queue')
@section('heading', 'Orders')

@section('content')
    <section class="menu-catalog-shell">
        @if (session('status'))
            <div class="admin-success">{{ session('status') }}</div>
        @endif

        <div class="menu-filter-panel">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="menu-filter-form">
                <div class="filter-group">
                    <label for="search">Search orders</label>
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Order number, customer, email">
                    </div>
                </div>

                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ Str::headline($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="filter-button apply">
                        <i class="fa-solid fa-sliders"></i>
                        Apply filters
                    </button>
                    @if (request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.orders.index') }}" class="filter-button reset">
                            <i class="fa-solid fa-xmark"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <section class="dashboard-card orders-card">
            <div class="panel-header">
                <div>
                    <p class="admin-kicker">Live database</p>
                    <h2>Order management</h2>
                </div>
                <span class="admin-role-pill">{{ $orders->total() }} orders</span>
            </div>

            <div class="orders-table-wrap">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Fulfillment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order->order_number ?: 'MC-'.$order->id }}<br><small>{{ $order->created_at->format('M d, Y g:i A') }}</small></td>
                                <td>{{ $order->customer?->name ?? 'Deleted customer' }}<br><small>{{ $order->customer?->email }}</small></td>
                                <td>{{ $order->items->map(fn ($item) => $item->quantity.'x '.$item->name)->join(', ') ?: 'No items' }}</td>
                                <td>₱{{ number_format((float) $order->total_price, 2) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="inline-update-form">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" aria-label="Order status">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}" @selected($order->status === $status)>{{ Str::headline($status) }}</option>
                                            @endforeach
                                        </select>
                                </td>
                                <td>
                                        <select name="fulfillment_method" aria-label="Fulfillment method">
                                            <option value="delivery" @selected($order->fulfillment_method === 'delivery')>Delivery</option>
                                            <option value="pickup" @selected($order->fulfillment_method === 'pickup')>Pickup</option>
                                        </select>
                                        <input name="delivery_location" type="text" value="{{ $order->delivery_location }}" placeholder="Location">
                                </td>
                                <td>
                                        <button type="submit" class="admin-menu-action-button edit-button">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                            Save
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="delete-form" onsubmit="return confirm('Delete this order?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-menu-action-button delete-button">
                                            <i class="fa-solid fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No orders match your filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $orders->links() }}
            </div>
        </section>
    </section>
@endsection
