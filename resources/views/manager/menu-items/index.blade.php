@extends('layouts.manager')

@section('title', 'Menu Items')
@section('kicker', 'Menu catalog')
@section('heading', 'Menu items')

@section('content')
<section class="menu-catalog-shell">
    @if (session('status'))
        <div class="admin-success">{{ session('status') }}</div>
    @endif

    <div class="menu-catalog-summary">
        <article>
            <span><i class="fa-solid fa-bowl-food"></i></span>
            <div>
                <strong>{{ $menuItems->count() }}</strong>
                <p>Total menu items</p>
            </div>
        </article>
        <article>
            <span><i class="fa-solid fa-tags"></i></span>
            <div>
                <strong>{{ $categories->count() }}</strong>
                <p>Categories</p>
            </div>
        </article>
        <article>
            <span><i class="fa-solid fa-circle-check"></i></span>
            <div>
                <strong>{{ $menuItems->where('is_available', true)->count() }}</strong>
                <p>Available today</p>
            </div>
        </article>
    </div>

    <div class="menu-toolbar-panel">
        <div>
            <p class="admin-kicker">Food business menu</p>
            <h2>All menu items</h2>
        </div>
    </div>

    <div class="menu-filter-panel">
        <form method="GET" action="{{ route('manager.menu-items.index') }}" class="menu-filter-form">
            <div class="filter-group">
                <label for="search">Search meals</label>
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="search" name="search" placeholder="Search by name or description" value="{{ request('search') }}">
                </div>
            </div>

            <div class="filter-group">
                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="">All categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="availability">Availability</label>
                <select id="availability" name="availability">
                    <option value="">All items</option>
                    <option value="1" @selected(request('availability') === '1')>Available only</option>
                    <option value="0" @selected(request('availability') === '0')>Unavailable only</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="filter-button apply">
                    <i class="fa-solid fa-sliders"></i>
                    Apply filters
                </button>
                @if (request()->hasAny(['search', 'category', 'availability']))
                    <a href="{{ route('manager.menu-items.index') }}" class="filter-button reset">
                        <i class="fa-solid fa-xmark"></i>
                        Reset filters
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="admin-menu-grid">
        @forelse ($menuItems as $menuItem)
            <article class="admin-menu-card">
                <div class="admin-menu-image">
                    @if ($menuItem->image_url)
                        <img src="{{ $menuItem->image_url }}" alt="{{ $menuItem->name }}">
                    @else
                        <i class="fa-solid fa-utensils"></i>
                    @endif
                    <span class="stock-pill {{ $menuItem->is_available ? '' : 'stock-low-stock' }}">
                        {{ $menuItem->is_available ? 'Available' : 'Unavailable' }}
                    </span>
                </div>
                <div class="admin-menu-body">
                    <small>{{ $menuItem->category }}</small>
                    <h3>{{ $menuItem->name }}</h3>
                    <p>{{ $menuItem->description ?: 'No description yet.' }}</p>
                    <strong>&#8369;{{ number_format((float) $menuItem->price, 2) }}</strong>
                </div>
                <div class="admin-menu-actions">
                    <a href="{{ route('manager.menu-items.edit', $menuItem) }}" class="admin-menu-action-button edit-button" title="Edit menu item">
                        <i class="fa-solid fa-pencil"></i>
                        Edit
                    </a>
                </div>
            </article>
        @empty
            <section class="empty-admin-panel menu-empty-state">
                <span><i class="fa-solid fa-bowl-food"></i></span>
                <h2>No menu items found</h2>
                <p>No menu items match your current filters.</p>
            </section>
        @endforelse
    </div>
</section>
@endsection
