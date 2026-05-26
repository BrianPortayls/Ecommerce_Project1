<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Manager') - {{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ filemtime(public_path('css/admin/dashboard.css')) }}">
    </head>
    <body>
        <main class="admin-shell">
            <aside class="admin-sidebar" aria-label="Manager navigation">
                <a href="{{ route('home') }}" class="admin-brand">
                    <span class="brand-mark"><i class="fa-solid fa-utensils"></i></span>
                    <span>{{ config('app.name', 'Micaller') }}</span>
                </a>

                <nav class="admin-nav">
                    <a href="{{ route('manager.dashboard') }}" class="admin-nav-link @if (request()->routeIs('manager.dashboard')) is-active @endif">
                        <i class="fa-solid fa-chart-line"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('manager.menu-items.index') }}" class="admin-nav-link @if (request()->routeIs('manager.menu-items.*')) is-active @endif">
                        <i class="fa-solid fa-bowl-food"></i>
                        Menu items
                    </a>

                    <a href="{{ route('home') }}" class="admin-nav-link">
                        <i class="fa-solid fa-store"></i>
                        View store
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="admin-nav-form">
                        @csrf
                        <button type="submit" class="admin-nav-sublink-logout">
                            <i class="fa-solid fa-sign-out-alt"></i>
                            Log out
                        </button>
                    </form>
                </nav>

                <div class="sidebar-note">
                    <i class="fa-solid fa-fire"></i>
                    <strong>Lunch rush</strong>
                    <span>Orders are 18% higher than yesterday.</span>
                </div>
            </aside>

            <section class="admin-main">
                <header class="admin-topbar">
                    <div>
                        <p class="admin-kicker">@yield('kicker', 'Manager')</p>
                        <h1>{!! $__env->yieldContent('heading', 'Dashboard') !!}</h1>
                    </div>

                    <div class="admin-actions">
                        @yield('actions')
                        <span class="admin-role-pill">Manager {{ Str::ucfirst(auth()->user()->name) }}</span>
                    </div>
                </header>

                @yield('content')
            </section>
        </main>

        @stack('scripts')
    </body>
</html>
