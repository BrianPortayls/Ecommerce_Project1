@extends('layouts.admin')

@section('title', 'Create Manager')
@section('kicker', 'Admin database')
@section('heading', 'Create manager account')

@section('content')
    <div id="toast-container" class="toast-container"></div>

    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessToast('Manager Created', 'New manager account has been created successfully.');
            });
        </script>
    @endif

    <div class="manager-grid">
        <section class="manager-form-card">
            <div class="form-header">
                <h3>New Manager</h3>
                <p>Create a new manager account for your team</p>
            </div>

            <form method="POST" action="{{ route('admin.managers.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Manager name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="john@example.com" required>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="••••••••" required>
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="admin-primary-button full-button">
                    <i class="fa-solid fa-user-plus"></i>
                    Create manager account
                </button>
            </form>
        </section>

        <section class="manager-list-card">
            <div class="list-header">
                <div>
                    <p class="admin-kicker">Current managers</p>
                    <h2>Manager accounts</h2>
                </div>
                <span class="manager-count">{{ $managers->total() }}</span>
            </div>

            <div class="manager-list">
                @forelse ($managers as $manager)
                    <div class="manager-row">
                        <span class="manager-avatar"><i class="fa-solid fa-user-tie"></i></span>
                        <div class="manager-info">
                            <strong>{{ $manager->name }}</strong>
                            <small>{{ $manager->email }}</small>
                        </div>
                        <div class="manager-actions">
                            <button class="manager-menu-btn" onclick="toggleMenu(this)">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="manager-menu">
                                <a href="{{ route('admin.managers.edit', $manager) }}" class="manager-menu-item edit-btn">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.managers.destroy', $manager) }}" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this manager?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="manager-menu-item delete-btn">
                                        <i class="fa-solid fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-users"></i>
                        <p>No manager accounts have been created yet.</p>
                    </div>
                @endforelse
            </div>

            <div class="admin-pagination">
                {{ $managers->links() }}
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    const icons = {
        success: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10"/></svg>',
        close: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6l-12 12"/><path d="M6 6l12 12"/></svg>'
    };

    function createToastEl(title, message) {
        const toast = document.createElement('div');
        toast.className = 'toast toast--slide-right';

        let inner = '';
        inner += `<div class="toast__icon" style="color:#10B981;background:#10B98118">${icons.success}</div>`;
        inner += `<div class="toast__content"><p class="toast__title">${title}</p><p class="toast__message">${message}</p></div>`;
        inner += `<button class="toast__close" onclick="dismissToast(this.parentElement)" aria-label="Close">${icons.close}</button>`;

        toast.innerHTML = inner;
        return toast;
    }

    function dismissToast(el) {
        el.classList.add('toast--exit');
        el.addEventListener('animationend', () => el.remove(), { once: true });
    }

    function showSuccessToast(title, message) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        container.innerHTML = '';
        const toast = createToastEl(title, message);
        container.appendChild(toast);

        setTimeout(() => {
            if (toast.parentElement) dismissToast(toast);
        }, 4000);
    }

    function toggleMenu(btn) {
        const menu = btn.nextElementSibling;
        const isOpen = menu.classList.contains('is-open');

        // Close all open menus
        document.querySelectorAll('.manager-menu.is-open').forEach(m => m.classList.remove('is-open'));

        // Toggle current menu
        if (!isOpen) {
            menu.classList.add('is-open');
        }
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.manager-actions')) {
            document.querySelectorAll('.manager-menu.is-open').forEach(m => m.classList.remove('is-open'));
        }
    });
</script>
@endpush
