@extends('layouts.app')

@section('content')

<style>
    .login-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        width: 100%;
        max-width: 380px;
        padding: 30px;
        border-radius: 18px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .login-logo {
        width: 60px;
        display: block;
        margin: 0 auto 10px;
    }

    .login-title {
        text-align: center;
        font-weight: 600;
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
    }

    .btn-login {
        border-radius: 10px;
        padding: 10px;
        font-weight: 500;
        background: linear-gradient(135deg, #2b3fa0, #3b52c4);
        border: none;
    }

    .btn-login:hover {
        opacity: 0.9;
    }
</style>

<div class="login-wrapper">

    <div class="login-card">

        <img src="{{ asset('assets/img/logo.png') }}" class="login-logo">

        <div class="login-title">
            Login Account
        </div>

        @if ($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
            </div>

            <button class="btn btn-login w-100 text-white">
                Login
            </button>
        </form>

    </div>

</div>

@endsection
