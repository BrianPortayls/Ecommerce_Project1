<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Create Manager - {{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ filemtime(public_path('css/admin/dashboard.css')) }}">
    </head>
    <body>
        <main class="admin-shell">
            <aside class="admin-sidebar" aria-label="Admin navigation">
                <a href="{{ route('home') }}" class="admin-brand">
                    <span class="brand-mark"><i class="fa-solid fa-utensils"></i></span>
                    <span>{{ config('app.name', 'Micaller') }}</span>
                </a>

                <nav class="admin-nav">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link">
                        <i class="fa-solid fa-chart-line"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.managers.create') }}" class="admin-nav-link is-active">
                        <i class="fa-solid fa-user-tie"></i>
                        Managers
                    </a>
                    <a href="{{ route('home') }}" class="admin-nav-link">
                        <i class="fa-solid fa-store"></i>
                        Storefront
                    </a>
                </nav>
            </aside>

            <section class="admin-main">
                <header class="admin-topbar">
                    <div>
                        <p class="admin-kicker">Admin database</p>
                        <h1>Create manager account</h1>
                    </div>

                    <div class="admin-actions">
                        <span class="admin-role-pill">Admin</span>
                        <a href="{{ route('admin.dashboard') }}" class="admin-soft-button">Back to dashboard</a>
                    </div>
                </header>

                <div class="manager-grid">
                    <section class="manager-form-card">
                        @if (session('status'))
                            <div class="admin-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.managers.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Manager name</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
                                @error('name') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                                @error('email') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" required>
                                @error('password') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required>
                            </div>

                            <button type="submit" class="admin-primary-button full-button">
                                <i class="fa-solid fa-user-plus"></i>
                                Create manager account
                            </button>
                        </form>
                    </section>

                    <section class="manager-list-card">
                        <p class="admin-kicker">Current managers</p>
                        <h2>Manager accounts</h2>

                        <div class="manager-list">
                            @forelse ($managers as $manager)
                                <div class="manager-row">
                                    <span><i class="fa-solid fa-user-tie"></i></span>
                                    <div>
                                        <strong>{{ $manager->name }}</strong>
                                        <small>{{ $manager->email }}</small>
                                    </div>
                                </div>
                            @empty
                                <p class="muted-text">No manager accounts have been created yet.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </body>
</html>
