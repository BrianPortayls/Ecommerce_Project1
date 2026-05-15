@extends('layouts.admin')

@section('title', 'Create Manager')
@section('kicker', 'Admin database')
@section('heading', 'Create manager account')

@section('actions')
    <a href="{{ route('admin.dashboard') }}" class="admin-soft-button">Back to dashboard</a>
@endsection

@section('content')
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
@endsection
