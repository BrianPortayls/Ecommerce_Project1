<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route($this->dashboardRoute(), absolute: false), navigate: true);
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
        <div class="row auth-shell justify-content-center">
            <section class="col-lg-5">
                <div class="auth-card mx-auto">
                    <a href="{{ route('home') }}" class="auth-brand mb-4" wire:navigate>
                        <span class="brand-mark"><i class="fa-solid fa-utensils"></i></span>
                        {{ config('app.name', 'Micaller') }}
                    </a>

                    <div class="auth-card-header">
                        <span class="auth-kicker">Secure area</span>
                        <h1 class="auth-card-title">Confirm password</h1>
                        <p class="auth-card-text">Please enter your password again before continuing.</p>
                    </div>

                    <x-auth-session-status class="auth-alert mb-3" :status="session('status')" />

                    <form wire:submit="confirmPassword">
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input wire:model="password" id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn auth-button w-100">
                            Confirm and continue
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>
