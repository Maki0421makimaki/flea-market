# flea-market

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:Maki0421makimaki/flea-market.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. `cp .env.example .env`、「.env.example」ファイルを 「.env」ファイルに命名を変更。
4. .envに以下の環境変数を追加
```text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=各自のMailtrapのUSERNAME
MAIL_PASSWORD=各自のMailtrapのPASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"

STRIPE_PUBLIC_KEY=各自のStripe公開可能キー
STRIPE_SECRET_KEY=各自のStripeシークレットキー
```
※本アプリではMailtrapとtripeを利用しています。
各自アカウントを作成し、認証情報を取得して設定してください。


5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```
8. 設定キャッシュのクリア
```bash
php artisan config:clear
```

## 使用技術(実行環境)
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

## ER図
![ER図](src/public/images/flea-market-er-diagram.drawio.png)

## URL
- 商品一覧画面：http://localhost/
- ログイン画面：http://localhost/login
- 会員登録画面：http://localhost/register
- phpMyAdmin:：http://localhost:8080/