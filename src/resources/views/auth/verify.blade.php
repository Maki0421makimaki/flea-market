<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
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
        <div class="result-content">
            <p class="result-text">
                登録していただいたメールアドレス認証メールを送付しました。<br>メール認証を完了してください。
            </p>
            <div class="verify-btn">
                <a class="verify-btn__item" href="https://mailtrap.io/" target="_blank">
                    認証はこちら
                </a>
            </div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"  class="resend-link-item">
                    認証メールを再送する
                </button>
            </form>
        </div>
    </main>
</body>
</html>




