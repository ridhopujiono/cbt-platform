@extends('layouts.app')

@section('title', 'Login Peserta')

@section('content')
<div class="login-wrapper">

    <div class="login-card">
        <h1 class="login-title">Login Peserta</h1>
        <p class="login-subtitle">
            Silakan masuk untuk memulai ujian
        </p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <button type="submit" class="btn-primary">
                Masuk
            </button>
        </form>

        <div class="login-footer">
            <small>Sistem Ujian Internal</small>
        </div>
    </div>

</div>
@endsection
