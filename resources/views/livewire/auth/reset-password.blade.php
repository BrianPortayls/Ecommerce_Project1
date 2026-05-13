<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PasswordReset) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
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
                        <h1 class="auth-card-title">Choose a new password</h1>
                        <p class="auth-card-text">Use a secure password so your account stays protected.</p>
                    </div>

                    <x-auth-session-status class="auth-alert mb-3" :status="session('status')" />

                    <form wire:submit="resetPassword">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input wire:model="email" id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" required autocomplete="email">
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
                            Reset password
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>
