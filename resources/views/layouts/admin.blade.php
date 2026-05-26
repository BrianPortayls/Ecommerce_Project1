<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Admin') - {{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ filemtime(public_path('css/admin/dashboard.css')) }}">
    </head>
    <body>
        <button type="button" class="admin-mobile-toggle" data-admin-nav-toggle aria-label="Open admin navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="admin-sidebar-backdrop" data-admin-nav-close></div>

        <main class="admin-shell">
            <aside class="admin-sidebar" aria-label="Admin navigation">
                <a href="{{ route('home') }}" class="admin-brand">
                    <span class="brand-mark"><i class="fa-solid fa-utensils"></i></span>
                    <span>{{ config('app.name', 'Micaller') }}</span>
                </a>

                <nav class="admin-nav">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link @if (request()->routeIs('admin.dashboard')) is-active @endif">
                        <i class="fa-solid fa-chart-line"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.menu-items.index') }}" class="admin-nav-link @if (request()->routeIs('admin.menu-items.*')) is-active @endif">
                        <i class="fa-solid fa-bowl-food"></i>
                        Menu items
                    </a>

                    <a href="{{ route('admin.customers.index') }}" class="admin-nav-link @if (request()->routeIs('admin.customers.*')) is-active @endif">
                        <i class="fa-solid fa-users"></i>
                        Customers
                    </a>

                    <a href="{{ route('admin.managers.create') }}" class="admin-nav-link @if (request()->routeIs('admin.managers.*')) is-active @endif">
                        <i class="fa-solid fa-user-tie"></i>
                        Managers
                    </a>

                    <a href="{{ route('admin.deliveries.index') }}" class="admin-nav-link @if (request()->routeIs('admin.deliveries.*')) is-active @endif">
                        <i class="fa-solid fa-motorcycle"></i>
                        Deliveries
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="admin-nav-link @if (request()->routeIs('admin.settings.*')) is-active @endif">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </a>

                    <a href="{{ route('admin.analytics.index') }}" class="admin-nav-link @if (request()->routeIs('admin.analytics.*')) is-active @endif">
                        <i class="fa-solid fa-chart-column"></i>
                        Analytics
                    </a>

                    <a href="{{ route('menus') }}" class="admin-nav-link">
                        <i class="fa-solid fa-store"></i>
                        View store
                    </a>
                </nav>

                <div class="sidebar-note">
                    <i class="fa-solid fa-fire"></i>
                    <strong>Lunch rush</strong>
                    <span>Orders are 18% higher than yesterday.</span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="admin-sidebar-logout">
                    @csrf
                    <button type="submit" class="admin-nav-logout-button">
                        <i class="fa-solid fa-sign-out-alt"></i>
                        Log out
                    </button>
                </form>
            </aside>

            <section class="admin-main">
                <header class="admin-topbar">
                    <div>
                        <p class="admin-kicker">@yield('kicker', 'Admin')</p>
                        <h1>{!! $__env->yieldContent('heading', 'Dashboard') !!}</h1>
                    </div>

                    <div class="admin-actions">
                        @yield('actions')
                        <span class="admin-role-pill">Admin</span>
                    </div>
                </header>

                @yield('content')
            </section>
        </main>

        @vite('resources/js/app.js')
        @stack('scripts')
    </body>
</html>
