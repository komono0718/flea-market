<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Flea Market</title>

    @yield('css')
</head>
<body>

<header>
    <ul class="header-nav">
        @if (Auth::check())
            <li class="header-nav__item">
                <a class="header-nav__link" href="/mypage">マイページ</a>
            </li>
            <li class="header-nav__item">
                <form action="/logout" method="post">
                    @csrf
                    <button class="header-nav__button">ログアウト</button>
                </form>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/sell">出品</a>
            </li>
        @endif
    </ul>
</header>

<main>
    @yield('content')
</main>

</body>
</html>