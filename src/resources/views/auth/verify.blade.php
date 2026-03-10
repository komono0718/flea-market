@extends('layouts.app')

@section('content')
<div class="verify-wrapper">

    <h2 class="verify-title">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </h2>

    @if (session('message'))
        <p class="error-text" style="text-align:center; margin-bottom:20px;">
            {{ session('message') }}
        </p>
    @endif

    <a href="http://localhost:8025" target="_blank" class="verify-main-btn">
        認証はこちらから
    </a>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="verify-resend-link">
            認証メールを再送する
        </button>
    </form>

</div>
@endsection