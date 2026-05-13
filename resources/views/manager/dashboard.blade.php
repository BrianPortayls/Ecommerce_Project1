<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-neutral-100 text-neutral-950 antialiased dark:bg-zinc-950 dark:text-white">
        <main class="mx-auto flex min-h-screen w-full max-w-6xl flex-col gap-6 px-6 py-10">
            <header class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('manager.dashboard') }}" class="flex items-center gap-3 text-lg font-semibold" wire:navigate>
                    <x-app-logo-icon class="size-9 fill-current text-yellow-600" />
                    <span>{{ config('app.name', 'Micaller') }}</span>
                </a>

                <nav class="flex items-center gap-4 text-sm font-medium text-neutral-600 dark:text-neutral-300">
                    <span class="rounded-full bg-yellow-100 px-3 py-1 font-semibold text-yellow-700">Manager</span>
                    <a href="{{ route('manager.dashboard') }}" wire:navigate>Manager</a>
                    <a href="{{ route('settings.profile') }}" wire:navigate>Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="font-semibold text-red-600">Log out</button>
                    </form>
                </nav>
            </header>

            <section class="rounded-lg border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                <p class="text-sm font-medium text-yellow-700 dark:text-yellow-400">Manager Area</p>
                <h1 class="mt-2 text-3xl font-semibold">Manager Dashboard</h1>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Welcome to the manager area.</p>
            </section>
        </main>

        @fluxScripts
    </body>
</html>
