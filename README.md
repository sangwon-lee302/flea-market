# COACHTECHフリマ

## 概要

プログラミングの学習を目的としたフリマアプリを作成するプロジェクト。ユーザー認証、マイページ、商品の閲覧や出品、購入などの基本的な機能を有する。

## 環境構築の手順

- `git clone git@github.com:sangwon-lee302/flea-market.git`
- `cd flea-market`
- `docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs`
- `cp .env.example .env`、`.env`編集(環境変数を変更)
- `cp .env.dusk.example .env.dusk.local`(Laravel Duskによるテストを実行するため)
- `sail up -d --build`
- `sail artisan key:generate`
- `sail artisan key:generate --env=dusk.local`
- `sail artisan storage:link`
- `sail artisan migrate --seed`
- `sail npm i`
- `sail npm run build`(Laravel Duskによるテスト実行のため`dev`ではなく`build`を使用)
- ホスト側のOSに直接`Node.js`をインストールする(huskyによるpre-commit時のlint-stagedのため)

## URL

- 商品一覧画面: http://localhost/
- 商品一覧画面（マイリスト）: http://localhost/?tab=mylist
- 会員登録画面: http://localhost/register
- ログイン画面: http://localhost/login
- 商品詳細画面: http://localhost/item/{item}
- 商品購入画面: http://localhost/purchase/{item}
- 送付先住所変更画面: http://localhost/purchase/address/{item}
- 商品出品画面: http://localhost/sell
- プロフィール画面: http://localhost/mypage
- プロフィール編集画面: http://localhost/mypage/profile
- プロフィール画面（購入した商品一覧）: http://localhost/mypage?page=buy
- プロフィール画面（出品した商品一覧）: http://localhost/mypage?page=sell
- mailpit: http://localhost:8025
- phpmyadmin: http://localhost:8080

## 使用技術

- Laravel 13.2.0
- PHP 8.5.3
- Mysql 8.4.8
- Node 24.14.0
- Mailpit v1.29.5
- phpmyadmin 5.2.3
- Selenium 4.43.0

## ER図

![ER図](./database-design.drawio.svg)

## その他

### 仕様書からの変更点

- MailhogやMailtrapの代わりにMailpitを使用
- プロフィール編集画面および商品出品画面にてバリデーションエラーによりリダイレクトした際、アップロードされた画像が自動で表示される機能は未実装（画像以外の表示機能は実装済み）

### 仕様書には明記されていない仕様に関して

- いいね機能を非同期通信（Ajax）を用いて実装したためテストコードはLaravel Duskを用いて実装（レスポンスの中身の確認だけでは本当に画面が正しく切り替わっているか保証できないため）
- 商品購入画面で選択した支払い方法がテーブルに即時表示される機能もAjaxを用いて実装しているため、テストの要件を満たすためにLaravel Duskを使用
- コンビニ決済はWebhook未実装のため購入処理（ordersテーブルへのレコード追加や商品一覧画面等での'Sold'表示など）が未実装（カード決済は実装済み）
