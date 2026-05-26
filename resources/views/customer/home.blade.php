@php
    $restaurants = [
        [
            'name' => 'Tapsilog Express',
            'tag' => 'Japanese Comfort',
            'rating' => '4.9',
            'time' => '20-30 min',
            'image' => 'https://images.squarespace-cdn.com/content/v1/5a81c36ea803bb1dd7807778/1594846820039-AO7F8150VQUY1O1VPGT7/Tapsilog',
        ],
        [
            'name' => 'Cornsilog Kitchen',
            'tag' => 'Fresh Pasta',
            'rating' => '4.8',
            'time' => '25-35 min',
            'image' => 'https://lalunacafe.ph/wp-content/uploads/2022/08/corned-beef-silog-1-1.jpg',
        ],
        [
            'name' => 'Porksilog Bistro',
            'tag' => 'Salads & Bowls',
            'rating' => '4.7',
            'time' => '15-25 min',
            'image' => 'https://www.bxtra.ph/images/thumbs/000/0004880_pork-silog.jpeg',
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

        <link href="{{ asset('css/customer/home.css') }}?v={{ filemtime(public_path('css/customer/home.css')) }}" rel="stylesheet" />
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
                        <a class="nav-link" href="{{ route('menus') }}">Menus</a>
                        <a class="nav-link" href="#about">About Us</a>
                        <a class="nav-link" href="#popular">Popular</a>
                        <a class="nav-link" href="#deals">Deals</a>
                        @auth
                            @if (auth()->user()->role === 'customer')
                                <a class="nav-link" href="{{ route('feedback') }}">Feedback</a>
                            @endif
                        @endauth
                    </div>

                    <div class="ms-lg-auto d-flex align-items-lg-center gap-2 nav-actions">
                        @auth
                            @php
                                $dashboardRoute = match (auth()->user()->role) {
                                    'admin' => route('admin.dashboard'),
                                    'manager' => route('manager.dashboard'),
                                    default => route('dashboard'),
                                };
                            @endphp
                            <a href="{{ $dashboardRoute }}" class="btn btn-soft">Dashboard</a>
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
            <section class="hero-section">
                <div class="container">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6">
                            <div class="hero-copy">
                                <span class="eyebrow"><i class="fa-solid fa-bolt"></i> Fast local delivery</span>
                                <h1 class="hero-title">Cravings handled before they turn dramatic.</h1>
                                <p class="hero-subtitle">Find warm bowls, crisp snacks, fresh drinks, and nearby favorites in a few quick clicks.</p>

                                <div class="search-panel">
                                    <div class="order-tabs" role="group" aria-label="Order type">
                                        <button class="order-tab active" type="button">
                                            <i class="fa-solid fa-motorcycle"></i>
                                            Delivery
                                        </button>
                                        <button class="order-tab" type="button">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                            Pickup
                                        </button>
                                    </div>

                                    <form class="food-search">
                                        <label class="visually-hidden" for="delivery-address">Delivery address</label>
                                        <div class="address-field">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <input id="delivery-address" type="text" class="form-control" placeholder="Enter your delivery address">
                                        </div>

                                        <a class="btn find-food-btn" href="{{ route('menus') }}">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            Order Now
                                        </a>
                                    </form>
                                </div>

                                <div class="hero-stats">
                                    <div>
                                        <strong>120+</strong>
                                        <span>local kitchens</span>
                                    </div>
                                    <div>
                                        <strong>25 min</strong>
                                        <span>average arrival</span>
                                    </div>
                                    <div>
                                        <strong>4.8</strong>
                                        <span>customer rating</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="hero-media">
                                <img
                                    src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&w=1400&auto=format&fit=crop"
                                    alt="Colorful meal bowl with vegetables"
                                    class="hero-image"
                                >
                                <div class="floating-card order-card">
                                    <span class="card-icon"><i class="fa-solid fa-fire"></i></span>
                                    <div>
                                        <strong>Trending now</strong>
                                        <span>Spicy chicken rice bowl</span>
                                    </div>
                                </div>
                                <div class="floating-card courier-card">
                                    <span class="card-icon"><i class="fa-solid fa-route"></i></span>
                                    <div>
                                        <strong>On the way</strong>
                                        <span>Arrives in 18 minutes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="about-section" id="about">
                <div class="container">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6">
                            <div class="section-heading">
                                <span class="section-kicker">About us</span>
                                <h2>Comfort food made fast, fresh, and close to home.</h2>
                            </div>
                            <p class="about-copy">
                                {{ config('app.name', 'Micaller') }} brings your favorite silog meals, sizzling plates, chicken dishes, and pancit together in one simple ordering experience. We focus on warm meals, reliable delivery, and flavors that feel familiar from the first bite.
                            </p>
                            <a href="{{ route('menus') }}" class="btn btn-primary-action about-btn">
                                View Menu
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <div class="about-grid">
                                <div class="about-card">
                                    <span><i class="fa-solid fa-kitchen-set"></i></span>
                                    <strong>Cooked daily</strong>
                                    <p>Meals are prepared fresh so every order lands warm and satisfying.</p>
                                </div>
                                <div class="about-card">
                                    <span><i class="fa-solid fa-motorcycle"></i></span>
                                    <strong>Quick delivery</strong>
                                    <p>Simple ordering and local delivery help dinner arrive without the wait.</p>
                                </div>
                                <div class="about-card wide">
                                    <span><i class="fa-solid fa-heart"></i></span>
                                    <strong>Built for cravings</strong>
                                    <p>From tapsilog to sizzling favorites, the menu is made for easy everyday comfort.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="restaurant-section" id="popular">
                <div class="container">
                    <div class="section-heading with-action">
                        <div>
                            <span class="section-kicker">Top picks</span>
                            <h2>People keep reordering</h2>
                        </div>
                        <a href="{{ route('menus') }}" class="text-link">View all <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <div class="row g-4">
                        @foreach ($restaurants as $restaurant)
                            <div class="col-lg-4 col-md-6">
                                <article class="restaurant-card">
                                    <div class="restaurant-image-wrap">
                                        <img src="{{ $restaurant['image'] }}" alt="{{ $restaurant['name'] }} meal" class="restaurant-image">
                                        <span class="delivery-badge">{{ $restaurant['time'] }}</span>
                                    </div>
                                    <div class="restaurant-body">
                                        <div>
                                            <h3>{{ $restaurant['name'] }}</h3>
                                            <p>{{ $restaurant['tag'] }}</p>
                                        </div>
                                        <span class="rating"><i class="fa-solid fa-star"></i> {{ $restaurant['rating'] }}</span>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="deal-section" id="deals">
                <div class="container">
                    <div class="deal-band">
                        <div>
                            <span class="section-kicker">Tonight's easy win</span>
                            <h2>Free delivery on your first order over $20.</h2>
                            <p>Pick your favorite spot, add something lovely on the side, and let dinner come to you.</p>
                        </div>
                        <a href="{{ route('register') }}" class="btn btn-light-action">Start ordering</a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container d-flex flex-column flex-md-row justify-content-between gap-3">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'Micaller') }}. Fresh food, fast.</span>
                <div class="footer-links">
                    <a href="#">Help</a>
                    <a href="#">Terms</a>
                    <a href="#">Privacy</a>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
