<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a href="/"><img src="{{ asset('images/COACHTECHヘッダーロゴ.png')}}" alt="サイトのロゴ"></a>
                <form action="{{ route('items.index') }}" method="get" class="search-form">
                    <input type="text" name="keyword" value="{{ old('keyword', $keyword ?? '') }}" placeholder="なにをお探しですか？">
                </form>
                <nav>
                    <ul class="header-nav">
                        <li>
                            @auth
                                <form action="/logout" method="post">
                                    @csrf
                                    <button class="header-nav__item--logout">ログアウト</button>
                                </form>
                            @else
                                <a class="header-nav__item--login" href="/login">ログイン</a>
                            @endauth
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__item--mypage" href="/mypage">マイページ</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__item--sell" href="/sell">出品</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>