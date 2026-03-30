# COACHTECHフリマ

## 概要

プログラミングの学習を目的としたフリマアプリを作成するプロジェクト。ユーザー認証、マイページ、商品の閲覧、出品、購入などの基本的な機能を有する。

## 環境構築の手順

- `git clone git@github.com:sangwon-lee302/flea-market.git`
- `cd flea-market`
- `docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd)":/opt -w /opt laravelsail/php84-composer:latest composer install --ignore-platform-reqs`
- `cp .env.example .env`、`.env`編集(OS環境変数を適宜変更)
- `sail up -d`
- `sail artisan key:generate`
- `sail artisan migrate --seed`
- `sail npm i && sail npm run dev`
- Node.jsをホスト側にインストールしていない場合、Node.jsをインストールする（huskyによるpre-commit時のコードフォーマットを正常に実行するため）

## 使用技術

- Laravel 13.2.0
- PHP 8.5.3
- Mysql 8.4.8
- Node 24.14.0

## ER図

![ER図](./database-design.drawio.svg)
