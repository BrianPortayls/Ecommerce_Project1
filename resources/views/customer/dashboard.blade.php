@php
    $quickCategories = [
        ['name' => 'Silog Meals', 'count' => '12 meals', 'icon' => 'fa-bowl-rice', 'color' => 'mint'],
        ['name' => 'Sizzling', 'count' => '8 plates', 'icon' => 'fa-fire-burner', 'color' => 'sun'],
        ['name' => 'Chicken', 'count' => '10 meals', 'icon' => 'fa-drumstick-bite', 'color' => 'rose'],
        ['name' => 'Drinks', 'count' => '9 choices', 'icon' => 'fa-glass-water', 'color' => 'sky'],
    ];

    $recommendedMeals = [
        [
            'name' => 'Tapsilog Supreme',
            'category' => 'Silog Meals',
            'price' => '&#8369;145',
            'rating' => '4.9',
            'time' => '20 min',
            'image' => 'https://images.squarespace-cdn.com/content/v1/5a81c36ea803bb1dd7807778/1594846820039-AO7F8150VQUY1O1VPGT7/Tapsilog',
        ],
        [
            'name' => 'Sizzling Sisig',
            'category' => 'Sizzling',
            'price' => '&#8369;165',
            'rating' => '4.9',
            'time' => '25 min',
            'image' => 'https://images.unsplash.com/photo-1625938144755-652e08e359b7?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'name' => 'Chicken Inasal',
            'category' => 'Chicken',
            'price' => '&#8369;155',
            'rating' => '4.8',
            'time' => '22 min',
            'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=1200&auto=format&fit=crop',
        ],
    ];

    $recentOrders = [
        ['name' => 'Cornsilog Kitchen', 'status' => 'Delivered', 'date' => 'Today', 'total' => '&#8369;120'],
        ['name' => 'Porksilog Bistro', 'status' => 'Preparing', 'date' => 'Yesterday', 'total' => '&#8369;135'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Dashboard | {{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('css/customer/dashboard.css') }}?v={{ filemtime(public_path('css/customer/dashboard.css')) }}" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg sticky-top site-nav">
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('home') }}">
                    <span class="logo-mark"><i class="fa-solid fa-utensils"></i></span>
                    {{ config('app.name', 'Micaller') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNav" aria-controls="dashboardNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="dashboardNav">
                    <div class="navbar-nav ms-lg-3 me-lg-auto nav-links">
                        <a class="nav-link" href="{{ route('menus') }}">Menus</a>
                        <a class="nav-link" href="#orders">Orders</a>
                        <a class="nav-link" href="{{ route('feedback') }}">Feedback</a>
                    </div>

                    <div class="dropdown ms-lg-auto nav-actions">
                        <button class="customer-badge dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open customer menu">
                            <img src="{{ asset('images/customer-account-icon.png') }}" alt="">
                        </button>

                        <div class="dropdown-menu dropdown-menu-end customer-menu">
                            <div class="customer-menu-header">
                                <img src="{{ asset('images/customer-account-icon.png') }}" alt="">
                                <strong>{{ auth()->user()->name }}</strong>
                                <span>{{ auth()->user()->email }}</span>
                            </div>

                            <a class="customer-menu-item" href="{{ route('settings.profile') }}">
                                <i class="fa-solid fa-user-gear"></i>
                                Settings
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="customer-menu-item danger">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <section class="dashboard-hero">
                <div class="container">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-7">
                            <span class="eyebrow"><i class="fa-solid fa-bolt"></i> Ready for your next order</span>
                            <h1>Hello, {{ auth()->user()->name }}.</h1>
                            <p>Pick up where you left off, reorder your favorites, or discover something fresh from the menu.</p>

                            <div class="hero-actions">
                                <a href="{{ route('menus') }}" class="btn btn-primary-action">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    Order now
                                </a>
                                <a href="#recommended" class="btn btn-soft">View favorites</a>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <article class="featured-order">
                                <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&w=1200&auto=format&fit=crop" alt="Fresh rice bowl meal">
                                <div class="featured-order-body">
                                    <span>Today's pick</span>
                                    <h2>Fresh rice bowl combo</h2>
                                    <p>Warm bowl, crisp vegetables, and a drink ready in 20 minutes.</p>
                                    <a href="{{ route('menus') }}" class="featured-link">Add to order <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section class="dashboard-section">
                <div class="container">
                    <div class="section-heading">
                        <span class="section-kicker">Quick browse</span>
                        <h2>Restaurant-style categories</h2>
                    </div>

                    <div class="category-grid">
                        @foreach ($quickCategories as $category)
                            <a href="{{ route('menus') }}" class="category-card category-{{ $category['color'] }}" style="--delay: {{ $loop->index * 90 }}ms">
                                <span class="category-icon"><i class="fa-solid {{ $category['icon'] }}"></i></span>
                                <strong>{{ $category['name'] }}</strong>
                                <small>{{ $category['count'] }}</small>
                                <i class="fa-solid fa-arrow-right category-arrow"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="dashboard-section recommended-section" id="recommended">
                <div class="container">
                    <div class="dashboard-grid">
                        <div>
                            <div class="menu-toolbar">
                                <div>
                                    <span class="section-kicker">Recommended</span>
                                    <h2>Meals you might like</h2>
                                </div>

                                <a href="{{ route('menus') }}" class="text-link">Full menu <i class="fa-solid fa-arrow-right"></i></a>
                            </div>

                            <div class="row g-4">
                                @foreach ($recommendedMeals as $meal)
                                    <div class="col-md-6 col-xl-4">
                                        <article class="meal-card" style="--delay: {{ $loop->index * 100 }}ms">
                                            <div class="meal-image-wrap">
                                                <img src="{{ $meal['image'] }}" alt="{{ $meal['name'] }}" class="meal-image">
                                                <span class="meal-time">{{ $meal['time'] }}</span>
                                            </div>
                                            <div class="meal-body">
                                                <div class="meal-head">
                                                    <div>
                                                        <small>{{ $meal['category'] }}</small>
                                                        <h3>{{ $meal['name'] }}</h3>
                                                    </div>
                                                    <span class="rating"><i class="fa-solid fa-star"></i> {{ $meal['rating'] }}</span>
                                                </div>
                                                <div class="meal-foot">
                                                    <strong>{!! $meal['price'] !!}</strong>
                                                    <button type="button" class="add-btn" aria-label="Add {{ $meal['name'] }} to order">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <aside class="dashboard-side" id="orders">
                            <section class="summary-card">
                                <span class="summary-icon"><i class="fa-solid fa-receipt"></i></span>
                                <h2>Your order</h2>
                                <p>Start adding meals and your order preview will be ready here.</p>

                                <div class="summary-line">
                                    <span>Subtotal</span>
                                    <strong>&#8369;0.00</strong>
                                </div>
                                <div class="summary-line">
                                    <span>Delivery</span>
                                    <strong>&#8369;49.00</strong>
                                </div>

                                <a href="{{ route('menus') }}" class="btn checkout-btn">Browse menu</a>
                            </section>

                            <section class="recent-card">
                                <div class="section-heading small">
                                    <span class="section-kicker">Recent</span>
                                    <h2>Order history</h2>
                                </div>

                                @foreach ($recentOrders as $order)
                                    <div class="recent-order">
                                        <span class="recent-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                                        <div>
                                            <strong>{{ $order['name'] }}</strong>
                                            <small>{{ $order['date'] }} - {{ $order['status'] }}</small>
                                        </div>
                                        <b>{!! $order['total'] !!}</b>
                                    </div>
                                @endforeach
                            </section>
                        </aside>
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
                    <a href="{{ route('feedback') }}">Feedback</a>
                    <a href="{{ route('settings.profile') }}">Settings</a>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
