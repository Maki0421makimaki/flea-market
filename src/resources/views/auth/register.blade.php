<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
        <div class="resister-form">
            <div class="register-form__heading">
                <h1>会員登録</h1>
            </div>
            <form class="form" action="/？？？？" method="post">
                @csrf
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="username">ユーザー名</label>
                    </div>
                    <div class="form__group--content">
                        <input type="text" id="name" name="name">
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group--title">
                        <label for="email">メールアドレス</label>
                    </div>
                    <div class="form__group--content">
                        <input type="email" id="email" name="email">
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group--title">
                        <label for="password">パスワード</label>
                    </div>
                    <div class="form__group--content">
                        <input type="password" id="password" name="password">
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group--title">
                        <label for="confirm-password">確認用パスワード</label>
                    </div>
                    <div class="form__group--content">
                        <input type="password" id="" name="confirm-password">
                    </div>
                </div>


                <div class="button-area">
                    <div class="form-btn">
                        <button class="form-btn__submit" type="submit">登録する</button>
                    </div>

                    <div class="login-link">
                        <a href="/login" class="login-link__item">ログインはこちら</a>
                    </div>
                </div>   
            </form>
        </div>
    </main>
</body>
</html>

