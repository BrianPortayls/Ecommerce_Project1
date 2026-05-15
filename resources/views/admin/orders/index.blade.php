@extends('layouts.admin')

@section('title', 'Orders')
@section('kicker', 'Order queue')
@section('heading', 'Orders')

@section('content')
<section class="empty-admin-panel">
    <span><i class="fa-solid fa-receipt"></i></span>
    <h2>Orders workspace</h2>
    <p>Use this area to manage incoming, preparing, and completed orders.</p>
</section>
@endsection
