@extends('layouts.admin')

@section('title', 'Menu Items')
@section('kicker', 'Menu catalog')
@section('heading', 'Menu items')

@section('actions')
    <button type="button" class="admin-primary-button" data-menu-form-toggle>
        <i class="fa-solid fa-plus"></i>
        Add menu
    </button>
@endsection

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

    <section class="inline-menu-form @if ($errors->any()) is-open @endif" data-menu-form>
        <div class="panel-header">
            <div>
                <p class="admin-kicker">New food item</p>
                <h2>Add menu without leaving this page</h2>
            </div>
            <button type="button" class="form-close-button" data-menu-form-close aria-label="Close add menu form">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.menu-items.store') }}" class="menu-item-form">
            @csrf

            <div class="form-group">
                <label for="name">Meal name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input id="category" name="category" type="text" value="{{ old('category') }}" list="menu-category-options" required>
                <datalist id="menu-category-options">
                    <option value="Silog Meals"></option>
                    <option value="Sizzling"></option>
                    <option value="Chicken"></option>
                    <option value="Pancit"></option>
                    <option value="Drinks"></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}"></option>
                    @endforeach
                </datalist>
                @error('category') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input id="price" name="price" type="number" min="0" max="999999.99" step="0.01" value="{{ old('price') }}" required>
                @error('price') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="is_available">Availability</label>
                <select id="is_available" name="is_available" required>
                    <option value="1" @selected(old('is_available', '1') === '1')>Available</option>
                    <option value="0" @selected(old('is_available') === '0')>Unavailable</option>
                </select>
                @error('is_available') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group full-span">
                <label for="image_url">Image URL</label>
                <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" placeholder="https://example.com/meal.jpg">
                @error('image_url') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group full-span">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="admin-primary-button full-span">
                <i class="fa-solid fa-circle-plus"></i>
                Save menu item
            </button>
        </form>
    </section>

    <div class="menu-toolbar-panel">
        <div>
            <p class="admin-kicker">Food business menu</p>
            <h2>All menu items</h2>
        </div>
    </div>

    <div class="menu-filter-panel">
        <form method="GET" action="{{ route('admin.menu-items.index') }}" class="menu-filter-form">
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
                    <a href="{{ route('admin.menu-items.index') }}" class="filter-button reset">
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
                    <a href="{{ route('admin.menu-items.edit', $menuItem) }}" class="admin-menu-action-button edit-button" title="Edit menu item">
                        <i class="fa-solid fa-pencil"></i>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.menu-items.destroy', $menuItem) }}" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-menu-action-button delete-button" title="Delete menu item">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <section class="empty-admin-panel menu-empty-state">
                <span><i class="fa-solid fa-bowl-food"></i></span>
                <h2>No menu items yet</h2>
                <p>Add your first meal from this page and it will appear in the catalog.</p>
            </section>
        @endforelse
    </div>
</section>

<script>
    document.querySelectorAll('[data-menu-form-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelector('[data-menu-form]')?.classList.add('is-open');
        });
    });

    document.querySelectorAll('[data-menu-form-close]').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelector('[data-menu-form]')?.classList.remove('is-open');
        });
    });
</script>
@endsection
