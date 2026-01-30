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
            <div>
                <a href="/" class="header__logo">COACHTECH</a>
            </div>
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