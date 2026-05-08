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

        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold logo" href="{{ route('home') }}">{{ config('app.name', 'Micaller') }}</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="ms-auto d-flex align-items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn login-btn">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn login-btn">Log in</a>
                            <a href="{{ route('register') }}" class="btn login-btn">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Side -->
                    <div class="col-lg-7">
                        <h1 class="hero-title">Are you starving?</h1>
                        <p class="hero-subtitle">Within a few clicks, find meals that are accessible near you.</p>

                        <div class="search-card">
                            <div class="d-flex gap-3">
                                <button class="btn delivery-btn" type="button">
                                    <i class="fa-solid fa-motorcycle"></i>
                                    Delivery
                                </button>
                                <button class="btn pickup-btn" type="button">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    Pickup
                                </button>
                            </div>

                            <form class="mt-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-lg-8">
                                        <div class="address-input-group d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <input
                                                type="text"
                                                class="form-control border-0"
                                                placeholder="Enter Your Address"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <button class="btn find-food-btn w-100" type="button">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            Find Food
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="col-lg-5 text-center mt-5 mt-lg-0">
                        <img
                            src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?q=80&w=1000&auto=format&fit=crop"
                            alt="Food Bowl"
                            class="img-fluid hero-image"
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Food Cards Section -->
        <section class="food-section py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="food-card">
                            <img
                                src="https://images.unsplash.com/photo-1547592180-85f173990554?q=80&w=1000&auto=format&fit=crop"
                                class="img-fluid"
                                alt="Food"
                            >
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="food-card">
                            <img
                                src="https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?q=80&w=1000&auto=format&fit=crop"
                                class="img-fluid"
                                alt="Food"
                            >
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="food-card">
                            <img
                                src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1000&auto=format&fit=crop"
                                class="img-fluid"
                                alt="Food"
                            >
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="food-card">
                            <img
                                src="https://images.unsplash.com/photo-1525755662778-989d0524087e?q=80&w=1000&auto=format&fit=crop"
                                class="img-fluid"
                                alt="Food"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
