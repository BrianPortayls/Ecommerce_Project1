@extends('layouts.admin')

@section('title', 'Customers')
@section('kicker', 'Customer records')
@section('heading', 'Customers')

@section('content')
    <section class="menu-catalog-shell">
        @if (session('status'))
            <div class="admin-success">{{ session('status') }}</div>
        @endif

        <div class="menu-filter-panel">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="menu-filter-form">
                <div class="filter-group">
                    <label for="search">Search customers</label>
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Name or email">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="filter-button apply">
                        <i class="fa-solid fa-sliders"></i>
                        Apply filters
                    </button>
                    @if (request()->has('search'))
                        <a href="{{ route('admin.customers.index') }}" class="filter-button reset">
                            <i class="fa-solid fa-xmark"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <section class="dashboard-card orders-card customer-records-card">
            <div class="panel-header">
                <div>
                    <p class="admin-kicker">Customer accounts</p>
                    <h2>Customer management</h2>
                </div>
                <span class="admin-role-pill">{{ $customers->total() }} customers</span>
            </div>

            <div class="orders-table-wrap">
                <table class="orders-table customer-records-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Orders</th>
                            <th>Total spent</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>
                                    <form id="customer-update-{{ $customer->id }}" method="POST" action="{{ route('admin.customers.update', $customer) }}" class="customer-profile-edit">
                                        @csrf
                                        @method('PUT')
                                        <span class="customer-avatar">{{ Str::of($customer->name)->trim()->substr(0, 1)->upper() }}</span>
                                        <span class="customer-fields">
                                            <input name="name" type="text" value="{{ $customer->name }}" aria-label="Customer name">
                                            <input name="email" type="email" value="{{ $customer->email }}" aria-label="Customer email">
                                        </span>
                                    </form>
                                </td>
                                <td><span class="customer-metric">{{ number_format($customer->orders_count) }}</span></td>
                                <td><span class="customer-metric">&#8369;{{ number_format((float) $customer->orders_sum_total_price, 2) }}</span></td>
                                <td><span class="customer-date">{{ $customer->created_at->format('M d, Y') }}</span></td>
                                <td>
                                    <div class="customer-action-stack">
                                        <button type="submit" form="customer-update-{{ $customer->id }}" class="admin-menu-action-button edit-button">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                            Save
                                        </button>
                                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="delete-form" onsubmit="return confirm('Delete this customer and their orders?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-menu-action-button delete-button">
                                                <i class="fa-solid fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No customers match your filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $customers->links() }}
            </div>
        </section>
    </section>
@endsection
