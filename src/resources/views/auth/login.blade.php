<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-logo">
                <a href="/"><img src="{{ asset('images/COACHTECHヘッダーロゴ.png')}}" alt="サイトのロゴ"></a>
            </div>
        </div>
    </header>
    <main>

        <div class="all-contents">
            <div class="login-form">
                <div class="login-form__heading">
                    <h1>ログイン</h1>
                </div>
                <form class="form" action="/login" method="post">
                    @csrf
                    <div class="form__group">
                        <div class="form__group--title">
                            <label for="email">メールアドレス</label>
                        </div>
                        <div class="form__group--content">
                            <input type="email" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <p class="login-form__error-message">
                            @if ($errors->has('email'))
                                @foreach($errors->get('email') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                        </p>
                    </div>

                    <div class="form__group">
                        <div class="form__group--title">
                            <label for="password">パスワード</label>
                        </div>
                        <div class="form__group--content">
                            <input type="password" id="password" name="password">
                        </div>
                        <p class="login-form__error-message">
                            @if ($errors->has('password'))
                                @foreach($errors->get('password') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                        </p>
                    </div>


                    <div class="button-area">
                        <div class="form-btn">
                            <button class="form-btn__submit" type="submit">ログインする</button>
                        </div>
                        <div class="login-link">
                            <a href="/register" class="login-link__item">会員登録はこちら</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>