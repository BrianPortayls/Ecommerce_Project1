<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
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
                    <span class="auth-kicker"><i class="fa-solid fa-heart"></i> Start ordering</span>
                    <h1 class="auth-title">Create your account for faster food days.</h1>
                    <p class="auth-text">Save your details, reach the menu quickly, and get back to the meals you already know you want.</p>
                </div>

                <img class="auth-hero-image" src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&w=1200&auto=format&fit=crop" alt="Fresh meal bowl">
            </section>

            <section class="col-lg-6">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <span class="auth-kicker">Register</span>
                        <h2 class="auth-card-title">Create account</h2>
                        <p class="auth-card-text">Fill in the form below to join {{ config('app.name', 'Micaller') }}.</p>
                    </div>

                    <x-auth-session-status class="auth-alert mb-3" :status="session('status')" />

                    <form wire:submit="register">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input wire:model="name" id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full name" required autofocus autocomplete="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input wire:model="email" id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com" required autocomplete="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input wire:model="password" id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm password</label>
                            <input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Confirm password" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn auth-button w-100">
                            Create account
                        </button>
                    </form>

                    <p class="mt-4 mb-0 text-center text-secondary">
                        Already have an account?
                        <a href="{{ route('login') }}" class="auth-link" wire:navigate>Log in</a>
                    </p>
                </div>
            </section>
        </div>
    </div>
</main>
