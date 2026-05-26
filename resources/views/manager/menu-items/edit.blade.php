@extends('layouts.manager')

@section('title', 'Edit Menu Item')
@section('kicker', 'Menu catalog')
@section('heading', 'Edit menu item')

@section('content')
<section class="menu-edit-shell">
    <article class="edit-menu-form-wrapper">
        <div class="panel-header">
            <div>
                <p class="admin-kicker">Edit food item</p>
                <h2>Update menu item details</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('manager.menu-items.update', $menuItem) }}" class="menu-item-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Meal name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $menuItem->name) }}" required>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input id="category" name="category" type="text" value="{{ old('category', $menuItem->category) }}" list="menu-category-options" required>
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
                <input id="price" name="price" type="number" min="0" max="999999.99" step="0.01" value="{{ old('price', $menuItem->price) }}" required>
                @error('price') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="is_available">Availability</label>
                <select id="is_available" name="is_available" required>
                    <option value="1" @selected(old('is_available', (int) $menuItem->is_available) === 1)>Available</option>
                    <option value="0" @selected(old('is_available', (int) $menuItem->is_available) === 0)>Unavailable</option>
                </select>
                @error('is_available') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group full-span">
                <label for="image_url">Image URL</label>
                <input id="image_url" name="image_url" type="url" value="{{ old('image_url', $menuItem->image_url) }}" placeholder="https://example.com/meal.jpg">
                @error('image_url') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group full-span">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3">{{ old('description', $menuItem->description) }}</textarea>
                @error('description') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group full-span edit-form-actions">
                <button type="submit" class="admin-primary-button">
                    <i class="fa-solid fa-circle-check"></i>
                    Save changes
                </button>
                <a href="{{ route('manager.menu-items.index') }}" class="admin-soft-button">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to menu
                </a>
            </div>
        </form>
    </article>

    <aside class="edit-menu-preview" aria-label="Menu item preview">
        <div class="edit-menu-preview-image">
            @if ($menuItem->image_url)
                <img src="{{ $menuItem->image_url }}" alt="{{ $menuItem->name }}">
            @else
                <i class="fa-solid fa-utensils"></i>
            @endif
        </div>
        <div class="edit-menu-preview-body">
            <span class="stock-pill {{ $menuItem->is_available ? '' : 'stock-low-stock' }}">
                {{ $menuItem->is_available ? 'Available' : 'Unavailable' }}
            </span>
            <small>{{ $menuItem->category }}</small>
            <h3>{{ $menuItem->name }}</h3>
            <p>{{ $menuItem->description ?: 'No description yet.' }}</p>
            <strong>&#8369;{{ number_format((float) $menuItem->price, 2) }}</strong>
        </div>
    </aside>
</section>
@endsection
