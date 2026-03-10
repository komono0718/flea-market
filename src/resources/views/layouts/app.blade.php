<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Flea Market</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=2">
    @yield('css')
</head>

<body>

<header class="header">
    <div class="header__logo">
        <img src="{{ asset('images/logo.png') }}">
    </div>

    {{-- login/registerだけ検索を非表示 --}}
    @if (!request()->is('login') && !request()->is('register'))
        <div class="header__search">
            <form action="/" method="GET" id="search-form">
                <input type="text"
                       name="keyword"
                       id="search-input"
                       placeholder="なにをお探しですか？"
                       value="{{ request('keyword') }}">
            </form>
        </div>
    @else
        <div></div>
    @endif

    <div class="header__nav">
        @auth
            <form action="/logout" method="post" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">ログアウト</button>
            </form>

            <a href="/mypage" class="mypage-link">マイページ</a>

            <a href="/sell" class="sell-btn">出品</a>
        @else
            @if (!request()->is('login'))
                <a href="/login" class="login-link">ログイン</a>
            @endif
        @endauth
    </div>
</header>


{{-- ここが重要 --}}
<div class="container">
    @yield('content')
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {

    const input = document.getElementById('search-input');
    const form = document.getElementById('search-form');

    if (!input || !form) return;

    let timer = null;

    input.addEventListener('input', function() {

        clearTimeout(timer);

        timer = setTimeout(function() {
            form.submit();
        }, 500);

    });

});
</script>

</body>
</html>