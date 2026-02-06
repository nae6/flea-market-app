<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flea Market App</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo">
                <img src="{{ asset('images/header_logo.png') }}" alt="coachtech logo">
            </a>
            <!-- register/loginでは表示なしにする -->
            @if (!request()->routeIs('login', 'register'))
            <form action="" method="GET" class="header__search">
                <input type="text" name="keyword" value="" placeholder="なにをお探しですか？" class="search__input">
            </form>
            <nav class="header__nav">
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="nav_link">ログイン</a>
                @endauth
                <a href="{{ route('mypage') }}" class="nav_link">マイページ</a>
                <a href="{{ route('sell') }}">出品</a>
            </nav>
            @endif
        </div>
    </header>

    <main>
        <div class="content">
            <div class="content__heading">
                <h1 class="content__title">@yield('page_title')</h1>
            </div>
            @yield('content')
        </div>
    </main>
</body>

</html>