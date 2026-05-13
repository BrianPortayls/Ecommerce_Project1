<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-neutral-100 text-neutral-950 antialiased dark:bg-zinc-950 dark:text-white">
        <main class="mx-auto min-h-screen w-full max-w-5xl px-6 py-10">
            <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
                @php
                    $homeRoute = match (auth()->user()->role) {
                        'admin' => route('admin.dashboard'),
                        'manager' => route('manager.dashboard'),
                        default => route('dashboard'),
                    };
                @endphp

                <a href="{{ $homeRoute }}" class="flex items-center gap-3 text-lg font-semibold" wire:navigate>
                    <x-app-logo-icon class="size-9 fill-current text-yellow-600" />
                    <span>{{ config('app.name', 'Micaller') }}</span>
                </a>

                <nav class="flex items-center gap-4 text-sm font-medium text-neutral-600 dark:text-neutral-300">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" wire:navigate>Admin</a>
                    @elseif (auth()->user()->isManager())
                        <a href="{{ route('manager.dashboard') }}" wire:navigate>Manager</a>
                    @else
                        <a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
                    @endif
                </nav>
            </header>

            <section class="rounded-lg border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                {{ $slot }}
            </section>
        </main>

        @fluxScripts
    </body>
</html>
