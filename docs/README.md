# Flea Market App

（草案）
Laravelで作成したフリマアプリです。
ユーザー登録・ログイン機能を備え、商品出品・購入ができるシンプルなマーケットプレイスを想定しています。

---

## 概要

- 出品者は商品を登録・編集・削除できます
- 購入者は商品一覧から商品を購入できます
- 購入済みの商品は再購入できない仕様です
- ポートフォリオ用として、設計・可読性・Laravelの標準的な実装を重視しています

---

## 使用技術

- PHP: 8.4.17
- Laravel: 12.49.0
- DB: MySQL
- MySQL: 8.0
- nginx: 1.28.1
- View: Blade
- Docker / Docker Compose

---

## 主な機能

- ユーザー登録 / ログイン
- 商品一覧表示
- 商品出品（CRUD）
- 商品購入（ダミー決済）
- カテゴリ分類
- 認可制御（出品者のみ編集・削除可能）

---

## ER図

※ 後で画像を追加

---

## テーブル設計（抜粋）

- users
- items
- categories
- orders

---

## 工夫した点

- Policyを用いた権限管理
- FormRequestによるバリデーションの分離
- Eloquentのリレーション・Scopeの活用
- 可読性を意識したController設計

---

## 苦労した点

- 出品者と購入者での権限制御
- 購入済み商品の状態管理
- データ整合性を保つ設計

---

## 今後の改善予定

- 画像アップロード機能
- 検索・絞り込み機能の強化
- 管理者画面の追加
- テストコードの拡充

---

## 環境構築

### 1. リポジトリをクローン
```bash
git clone
cd flea-market-app
```

### 2. Dockerビルド
```bash
docker compose up -d --build
```

### 3. Laravel環境構築

#### 1. PHPコンテナに入る
```bash
docker compose exec php bash
```

#### 2. Laravelパッケージのインストール
```bash
composer install
```

#### 3. .env作成
```bash
cp .env.example .env
php artisan key:generate
```
.envを以下のように設定してください

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

#### 4. データベース初期化
```bash
php artisan migrate
php artisan db:seed
```