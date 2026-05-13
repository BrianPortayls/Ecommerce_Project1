<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
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
                        <span class="auth-kicker">Password help</span>
                        <h1 class="auth-card-title">Reset your password</h1>
                        <p class="auth-card-text">Enter your email address and we will send a reset link if the account exists.</p>
                    </div>

                    <x-auth-session-status class="auth-alert mb-3" :status="session('status')" />

                    <form wire:submit="sendPasswordResetLink">
                        <div class="mb-4">
                            <label for="email" class="form-label">Email address</label>
                            <input wire:model="email" id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com" required autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn auth-button w-100">
                            Send reset link
                        </button>
                    </form>

                    <p class="mt-4 mb-0 text-center text-secondary">
                        Remember your password?
                        <a href="{{ route('login') }}" class="auth-link" wire:navigate>Log in</a>
                    </p>
                </div>
            </section>
        </div>
    </div>
</main>
