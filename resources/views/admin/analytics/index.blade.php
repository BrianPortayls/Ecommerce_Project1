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
@endsection
    </div>
</div>
@endsection
