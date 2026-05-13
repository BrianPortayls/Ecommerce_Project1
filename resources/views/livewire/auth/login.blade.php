<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route($this->dashboardRoute(), absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    protected function dashboardRoute(): string
    {
        return match (Auth::user()->role) {
            'admin' => 'admin.dashboard',
            'manager' => 'manager.dashboard',
            default => 'dashboard',
        };
    }
}; ?>

<main class="auth-page">
    <div class="container">
        <div class="row auth-shell g-5">
            <section class="col-lg-6">
                <a href="{{ route('home') }}" class="auth-brand" wire:navigate>
                    <span class="brand-mark"><i class="fa-solid fa-utensils"></i></span>
                    {{ config('app.name', 'Micaller') }}
                </a>

                <div class="auth-copy mt-5">
                    <span class="auth-kicker"><i class="fa-solid fa-bolt"></i> Fast local delivery</span>
                    <h1 class="auth-title">Welcome back to your food hub.</h1>
                    <p class="auth-text">Log in to continue managing orders, checking meals, and keeping every craving moving smoothly.</p>
                </div>

                <div class="auth-highlights">
                    <div class="highlight-card">
                        <i class="fa-solid fa-receipt"></i>
                        <strong>Orders</strong>
                        <span>Track every request</span>
                    </div>
                    <div class="highlight-card">
                        <i class="fa-solid fa-bowl-food"></i>
                        <strong>Menu</strong>
                        <span>Keep food updated</span>
                    </div>
                    <div class="highlight-card">
                        <i class="fa-solid fa-motorcycle"></i>
                        <strong>Delivery</strong>
                        <span>Serve customers fast</span>
                    </div>
                </div>
            </section>

            <section class="col-lg-6">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <span class="auth-kicker">Sign in</span>
                        <h2 class="auth-card-title">Login</h2>
                        <p class="auth-card-text">Enter your account details to continue.</p>
                    </div>

                    <x-auth-session-status class="auth-alert mb-3" :status="session('status')" />

                    <form wire:submit="login">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input wire:model="email" id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="admin@example.com" required autofocus autocomplete="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between gap-3">
                                <label for="password" class="form-label">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="auth-link small" wire:navigate>Forgot password?</a>
                                @endif
                            </div>
                            <input wire:model="password" id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input wire:model="remember" id="remember" type="checkbox" class="form-check-input">
                            <label for="remember" class="form-check-label">Remember me</label>
                        </div>

                        <button type="submit" class="btn auth-button w-100">
                            Log in
                        </button>
                    </form>

                    <p class="mt-4 mb-0 text-center text-secondary">
                        New here?
                        <a href="{{ route('register') }}" class="auth-link" wire:navigate>Create an account</a>
                    </p>
                </div>
            </section>
        </div>
    </div>
</main>
