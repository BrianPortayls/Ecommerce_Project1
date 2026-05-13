<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route($this->dashboardRoute(), absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
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
                <div class="auth-card mx-auto text-center">
                    <a href="{{ route('home') }}" class="auth-brand justify-content-center mb-4" wire:navigate>
                        <span class="brand-mark"><i class="fa-solid fa-utensils"></i></span>
                        {{ config('app.name', 'Micaller') }}
                    </a>

                    <div class="auth-card-header">
                        <span class="auth-kicker justify-content-center">Email verification</span>
                        <h1 class="auth-card-title">Check your inbox</h1>
                        <p class="auth-card-text">{{ __('Please verify your email address by clicking on the link we just emailed to you.') }}</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="auth-alert mb-3">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="d-grid gap-3">
                        <button wire:click="sendVerification" type="button" class="btn auth-button">
                            Resend verification email
                        </button>

                        <button wire:click="logout" type="button" class="btn btn-link auth-link">
                            Log out
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
