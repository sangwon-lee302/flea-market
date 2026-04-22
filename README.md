# COACHTECHフリマ

## 概要

プログラミングの学習を目的としたフリマアプリを作成するプロジェクト。ユーザー認証、マイページ、商品の閲覧、出品、購入などの基本的な機能を有する。

## 環境構築の手順

- `git clone git@github.com:sangwon-lee302/flea-market.git`
- `cd flea-market`
- `docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs`
- `cp .env.example .env`、`.env`編集(OS環境変数を適宜変更)
- `sail up -d`
- `sail artisan key:generate`
- `sail artisan migrate --seed`
- `sail npm i && sail npm run dev`
- ホスト側のOSに直接`Node.js`をインストールする(lint-stagedを使用するのため)

## 使用技術

- Laravel 13.2.0
- PHP 8.5.3
- Mysql 8.4.8
- Node 24.14.0
- Mailpit v1.29.5

## ER図

![ER図](./database-design.drawio.svg)

## その他

### 仕様書からの変更点

- MailhogやMailtrapの代わりにMailpitを使用
- 商品詳細画面で未認証ユーザーにはコメント欄を非表示にし「ログインしてコメントを入力」というボタンを表示
