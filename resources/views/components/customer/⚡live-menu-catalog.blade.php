<?php

use App\Models\MenuItem;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component
{
    public string $selectedCategory = 'All';

    public function mount(?string $selectedCategory = null): void
    {
        if ($selectedCategory && in_array($selectedCategory, $this->categories(), true)) {
            $this->selectedCategory = $selectedCategory;
        }
    }

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = in_array($category, $this->categories(), true) ? $category : 'All';
    }

    /**
     * @return list<string>
     */
    public function categories(): array
    {
        return MenuItem::query()
            ->where('is_available', true)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->prepend('All')
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, array{name: string, category: string, price: string, rating: string, tag: string, description: string, image: string}>
     */
    public function menus(): Collection
    {
        $categories = $this->categories();

        if (! in_array($this->selectedCategory, $categories, true)) {
            $this->selectedCategory = 'All';
        }

        return MenuItem::query()
            ->where('is_available', true)
            ->when($this->selectedCategory !== 'All', fn ($query) => $query->where('category', $this->selectedCategory))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn (MenuItem $menuItem): array => [
                'name' => $menuItem->name,
                'category' => $menuItem->category,
                'price' => '&#8369;'.number_format((float) $menuItem->price, 2),
                'rating' => '4.8',
                'tag' => 'Available',
                'description' => $menuItem->description ?: 'Freshly prepared and ready for pickup or delivery.',
                'image' => $menuItem->image_url ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop',
            ]);
    }
};
?>

<div wire:poll.3s>
    <div class="category-pills" aria-label="Menu categories">
        @foreach ($this->categories() as $category)
            <a
                class="category-pill {{ $selectedCategory === $category ? 'active' : '' }}"
                href="{{ $category === 'All' ? route('menus').'#specials' : route('menus', ['category' => $category]).'#specials' }}"
                wire:click.prevent="selectCategory({{ Js::from($category) }})"
            >
                {{ $category }}
            </a>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-9">
            <div class="row g-4">
                @forelse ($this->menus() as $menu)
                    <div class="col-lg-4 col-md-6">
                        <article class="menu-card">
                            <div class="menu-image-wrap">
                                <img src="{{ $menu['image'] }}" alt="{{ $menu['name'] }}" class="menu-image">
                                <span class="menu-tag">{{ $menu['tag'] }}</span>
                            </div>
                            <div class="menu-card-body">
                                <div class="menu-card-head">
                                    <div>
                                        <small>{{ $menu['category'] }}</small>
                                        <h3>{{ $menu['name'] }}</h3>
                                    </div>
                                    <span class="rating"><i class="fa-solid fa-star"></i> {{ $menu['rating'] }}</span>
                                </div>
                                <p>{{ $menu['description'] }}</p>
                                <div class="menu-card-foot">
                                    <strong>{!! $menu['price'] !!}</strong>
                                    <button class="add-btn" type="button" aria-label="Add {{ $menu['name'] }} to order">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-menu-state">
                            <span class="summary-icon"><i class="fa-solid fa-bowl-food"></i></span>
                            <h3>No meals found</h3>
                            <p>Try another category or return to the full menu.</p>
                            <button type="button" class="btn btn-soft" wire:click="selectCategory('All')">Show all meals</button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-xl-3">
            @auth
            <aside class="order-summary">
                <span class="summary-icon"><i class="fa-solid fa-receipt"></i></span>
                <h2>Your order</h2>
                <p>Select meals from the menu to build a quick order preview.</p>

                <div class="summary-line">
                    <span>Subtotal</span>
                    <strong>&#8369;0.00</strong>
                </div>
                <div class="summary-line">
                    <span>Delivery</span>
                    <strong>&#8369;49.00</strong>
                </div>

                <button class="btn checkout-btn" type="button">Checkout</button>
            </aside>
            @else
            <aside class="order-summary auth-summary">
                <span class="summary-icon"><i class="fa-solid fa-lock"></i></span>
                <h2>Sign in to checkout</h2>
                <p>You can browse the menu now. Create an account or log in when you are ready to place an order.</p>

                <div class="auth-actions">
                    <a href="{{ route('login') }}" class="btn btn-soft">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary-action">Register</a>
                </div>
            </aside>
            @endauth
        </div>
    </div>
</div>
