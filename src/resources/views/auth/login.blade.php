@extends('layouts.app')

@section('content')
    <div class="auth-container">

        <h1 class="auth-title">ログイン</h1>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label>メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}">

                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password">

                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                ログインする
            </button>

            <div class="auth-link">
                <a href="/register">会員登録はこちら</a>
            </div>

        </form>

    </div>
@endsection
