@php
    $defaultCategories = ['All', 'Silog Meals', 'Sizzling', 'Chicken', 'Pancit', 'Drinks'];

    $menuCategories = [
        ['name' => 'Silog Meals', 'items' => '12 meals', 'icon' => 'fa-bowl-rice', 'color' => 'mint', 'description' => 'Garlic rice, egg, and classic Filipino breakfast plates.'],
        ['name' => 'Sizzling', 'items' => '8 plates', 'icon' => 'fa-fire-burner', 'color' => 'sun', 'description' => 'Hot plate favorites served rich, savory, and fresh.'],
        ['name' => 'Chicken', 'items' => '10 meals', 'icon' => 'fa-drumstick-bite', 'color' => 'rose', 'description' => 'Grilled, crispy, and saucy chicken comfort meals.'],
        ['name' => 'Pancit', 'items' => '6 dishes', 'icon' => 'fa-bowl-food', 'color' => 'sky', 'description' => 'Noodle dishes made for solo cravings or sharing.'],
    ];

    $featured = [
        'name' => 'Tapsilog Supreme',
        'description' => 'Beef tapa, garlic rice, sunny egg, atsara, and house vinegar.',
        'price' => '₱145',
        'image' => 'https://images.squarespace-cdn.com/content/v1/5a81c36ea803bb1dd7807778/1594846820039-AO7F8150VQUY1O1VPGT7/Tapsilog',
    ];

    $featuredSlides = [
        [
            'name' => 'Tapsilog Supreme',
            'label' => 'Chef pick',
            'description' => 'Beef tapa, garlic rice, sunny egg, atsara, and house vinegar.',
            'price' => '&#8369;145',
            'image' => 'https://images.squarespace-cdn.com/content/v1/5a81c36ea803bb1dd7807778/1594846820039-AO7F8150VQUY1O1VPGT7/Tapsilog',
        ],
        [
            'name' => 'Sizzling Sisig',
            'label' => 'Hot plate',
            'description' => 'Creamy sisig served sizzling with calamansi, chili, and garlic rice.',
            'price' => '&#8369;165',
            'image' => 'https://images.unsplash.com/photo-1625938144755-652e08e359b7?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'name' => 'Chicken Inasal',
            'label' => 'Grill favorite',
            'description' => 'Char-grilled chicken with java rice, chicken oil, and dipping sauce.',
            'price' => '&#8369;155',
            'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=1200&auto=format&fit=crop',
        ],
    ];

    $defaultMenus = [
        [
            'name' => 'Tapsilog',
            'category' => 'Silog Meals',
            'price' => '₱145',
            'rating' => '4.9',
            'tag' => 'Best Seller',
            'description' => 'Tender beef tapa with garlic rice, egg, and atsara.',
            'image' => 'https://images.squarespace-cdn.com/content/v1/5a81c36ea803bb1dd7807778/1594846820039-AO7F8150VQUY1O1VPGT7/Tapsilog',
        ],
        [
            'name' => 'Cornsilog',
            'category' => 'Silog Meals',
            'price' => '₱120',
            'rating' => '4.8',
            'tag' => 'Popular',
            'description' => 'Corned beef, fried egg, and garlic rice for a classic comfort plate.',
            'image' => 'https://lalunacafe.ph/wp-content/uploads/2022/08/corned-beef-silog-1-1.jpg',
        ],
        [
            'name' => 'Porksilog',
            'category' => 'Silog Meals',
            'price' => '₱135',
            'rating' => '4.7',
            'tag' => 'New',
            'description' => 'Crispy pork strips served with egg, garlic rice, and dipping sauce.',
            'image' => 'https://www.bxtra.ph/images/thumbs/000/0004880_pork-silog.jpeg',
        ],
        [
            'name' => 'Sizzling Sisig',
            'category' => 'Sizzling',
            'price' => '₱165',
            'rating' => '4.9',
            'tag' => 'Hot Plate',
            'description' => 'Creamy, savory sisig served sizzling with calamansi and chili.',
            'image' => 'https://images.unsplash.com/photo-1625938144755-652e08e359b7?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'name' => 'Chicken Inasal',
            'category' => 'Chicken',
            'price' => '₱155',
            'rating' => '4.8',
            'tag' => 'Grilled',
            'description' => 'Char-grilled chicken with java rice and chicken oil.',
            'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'name' => 'Pancit Canton',
            'category' => 'Pancit',
            'price' => '₱130',
            'rating' => '4.6',
            'tag' => 'Shareable',
            'description' => 'Stir-fried noodles with vegetables, pork, shrimp, and calamansi.',
            'image' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=1200&auto=format&fit=crop',
        ],
    ];

    $selectedCategory = $selectedCategory ?? 'All';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Menus | {{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

        <link href="{{ asset('css/customer/menu.css') }}?v={{ filemtime(public_path('css/customer/menu.css')) }}" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg sticky-top site-nav">
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('home') }}">
                    <span class="logo-mark"><i class="fa-solid fa-utensils"></i></span>
                    {{ config('app.name', 'Micaller') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="navbar-nav ms-lg-3 me-lg-auto nav-links">
                        <a class="nav-link active" href="{{ route('menus') }}">Menus</a>
                        <a class="nav-link" href="#categories">Categories</a>
                        <a class="nav-link" href="#specials">Specials</a>
                    </div>

                    <div class="ms-lg-auto d-flex align-items-lg-center gap-2 nav-actions">
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-primary-action">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-soft">Log in</a>
                            <a href="{{ route('register') }}" class="btn btn-primary-action">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <section class="menu-hero">
                <div class="container">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <span class="eyebrow"><i class="fa-solid fa-bowl-food"></i> Freshly cooked daily</span>
                            <h1>Choose your next comfort meal.</h1>
                            <p>Browse silog plates, sizzling favorites, chicken meals, pancit, and add-ons ready for pickup or delivery.</p>
                        </div>

                        <div class="col-lg-5">
                            <div id="featuredMenuCarousel" class="carousel slide featured-carousel" data-bs-ride="carousel" data-bs-interval="3500">
                                <div class="carousel-indicators featured-indicators">
                                    @foreach ($featuredSlides as $slide)
                                        <button
                                            type="button"
                                            data-bs-target="#featuredMenuCarousel"
                                            data-bs-slide-to="{{ $loop->index }}"
                                            class="{{ $loop->first ? 'active' : '' }}"
                                            aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                            aria-label="Featured meal {{ $loop->iteration }}"
                                        ></button>
                                    @endforeach
                                </div>

                                <div class="carousel-inner">
                                    @foreach ($featuredSlides as $slide)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <article class="featured-menu">
                                                <img src="{{ $slide['image'] }}" alt="{{ $slide['name'] }}" class="featured-image">
                                                <div class="featured-content">
                                                    <span>{{ $slide['label'] }}</span>
                                                    <h2>{{ $slide['name'] }}</h2>
                                                    <p>{{ $slide['description'] }}</p>
                                                    <strong>{!! $slide['price'] !!}</strong>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="menu-category-section" id="categories">
                <div class="container">
                    <div class="section-heading">
                        <span class="section-kicker">Browse categories</span>
                        <h2>Find the plate you are craving.</h2>
                    </div>

                    <div class="menu-category-grid">
                        @foreach ($menuCategories as $category)
                            <a href="{{ route('menus', ['category' => $category['name']]) }}#specials" class="menu-category-card category-{{ $category['color'] }}" style="--delay: {{ $loop->index * 90 }}ms">
                                <span class="menu-category-icon">
                                    <i class="fa-solid {{ $category['icon'] }}"></i>
                                </span>
                                <span class="menu-category-content">
                                    <strong>{{ $category['name'] }}</strong>
                                    <small>{{ $category['items'] }}</small>
                                    <p>{{ $category['description'] }}</p>
                                </span>
                                <i class="fa-solid fa-arrow-right category-arrow"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="menu-section" id="specials">
                <div class="container">
                    <div class="menu-toolbar">
                        <div>
                            <span class="section-kicker">Full menu</span>
                            <h2>Order-ready favorites</h2>
                        </div>

                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="search" placeholder="Search meals">
                        </div>
                    </div>

                    <div class="category-pills" aria-label="Menu categories">
                        @foreach ($categories as $category)
                            <a class="category-pill {{ $selectedCategory === $category ? 'active' : '' }}" href="{{ $category === 'All' ? route('menus').'#specials' : route('menus', ['category' => $category]).'#specials' }}">
                                {{ $category }}
                            </a>
                        @endforeach
                    </div>

                    <div class="row g-4">
                        <div class="col-xl-9">
                            <div class="row g-4">
                                @forelse ($menus as $menu)
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
                                            <a href="{{ route('menus') }}#specials" class="btn btn-soft">Show all meals</a>
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
                                    <strong>₱0.00</strong>
                                </div>
                                <div class="summary-line">
                                    <span>Delivery</span>
                                    <strong>₱49.00</strong>
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
            </section>
        </main>

        <footer class="site-footer">
            <div class="container d-flex flex-column flex-md-row justify-content-between gap-3">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'Micaller') }}. Fresh food, fast.</span>
                <div class="footer-links">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('menus') }}">Menus</a>
                    @auth
                        @if (auth()->user()->role === 'customer')
                            <a href="{{ route('feedback') }}">Feedback</a>
                        @endif
                    @endauth
                    <a href="#">Help</a>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
