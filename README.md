# Flea Market App（フリマアプリ）

Laravelを使用して作成したフリマアプリです。  
ユーザーは商品を出品・購入・コメント・いいねすることができます。

---

# 環境構築

## Dockerビルド

1. リポジトリをクローン
git clone git@github.com:komono0718/flea-market.git

2. Dockerコンテナ起動

```bash
docker compose up -d –-build
```

---

# Laravel環境構築

1. PHPコンテナに入る

```bash
docker compose exec php bash
```

2. composerインストール

```bash
composer install
```

3. .env作成

```bash
cp .env.example .env
```

4. アプリケーションキー作成

```bash
php artisan key:generate
```

5. マイグレーション

```bash
php artisan migrate
```

6. シーディング

```bash
php artisan db:seed
```

7. storageリンク

```bash
php artisan storage:link
```

---

# 使用技術

- PHP 8.x
- Laravel 8.x
- MySQL
- Docker
- Fortify（認証）

---

# URL

- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8088/

---

# 機能一覧

### 認証

- 会員登録
- ログイン
- ログアウト
- メール認証

### 商品

- 商品一覧表示
- 商品検索
- 商品詳細表示
- 商品出品

### ユーザー

- プロフィール表示
- プロフィール編集
- マイページ

### アクション

- いいね機能
- コメント機能
- 商品購入

---

# テーブル設計

| テーブル | 説明 |
|---|---|
| users | ユーザー |
| items | 商品 |
| categories | カテゴリ |
| category_item | 商品カテゴリ |
| likes | いいね |
| comments | コメント |
| purchases | 購入 |

---
