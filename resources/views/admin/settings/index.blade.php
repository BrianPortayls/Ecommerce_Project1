@extends('layouts.admin')

@section('title', 'Admin Settings')
@section('kicker', 'Admin settings')
@section('heading', 'Store settings')

@section('content')
<div class="settings-panel">
    @if (session('success'))
        <div class="admin-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="settings-form">
        @csrf
        @forelse ($settings as $setting)
            <div class="form-group">
                <label for="{{ $setting->key }}">{{ Str::headline($setting->key) }}</label>
                <input id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" type="text" value="{{ old('settings.' . $setting->key, $setting->value) }}">
            </div>
        @empty
            <p class="muted-text">No settings have been added yet.</p>
        @endforelse

        <button type="submit" class="admin-primary-button">Save settings</button>
    </form>
</div>
@endsection
