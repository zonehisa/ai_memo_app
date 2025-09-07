---
marp: true
theme: default
paginate: true
footer: 'AI メモアプリ - Laravel + Livewire Volt'
---

# AI メモアプリ
## Laravel + Livewire Volt で構築

---

## 📋 プロジェクト概要

- **アプリ名**: AI メモアプリ
- **目的**: ユーザーがメモを効率的に管理できるWebアプリケーション
- **技術スタック**: Laravel 12.x + Livewire Volt + TailwindCSS
- **開発環境**: Docker (Laravel Sail)

---

## 🏗️ アーキテクチャ

### 技術スタック詳細
- **バックエンド**: Laravel 12.x (PHP 8.4+)
- **フロントエンド**: Livewire Volt + Flux UI
- **データベース**: SQLite
- **CSS Framework**: TailwindCSS
- **テストフレームワーク**: Pest
- **開発環境**: Laravel Sail (Docker)

---

## 🗄️ データベース設計

### メインテーブル: `memos`

| カラム名 | データ型 | 説明 |
|----------|----------|------|
| id | BIGINT UNSIGNED | 主キー |
| user_id | BIGINT UNSIGNED | ユーザーID (FK) |
| title | VARCHAR(255) | メモのタイトル |
| body | TEXT | メモの本文 |
| created_at | TIMESTAMP | 作成日時 |
| updated_at | TIMESTAMP | 更新日時 |

---

## 🔗 リレーション設計

```php
// User モデル (1対多)
public function memos(): HasMany
{
    return $this->hasMany(Memo::class);
}

// Memo モデル (多対1)
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

**削除時の動作**: ユーザー削除時にメモも自動削除 (CASCADE)

---

## 📝 サンプルデータ

| ID | タイトル | 内容 |
|----|----------|------|
| 1 | PHP | PHPは、Hypertext Preprocessorの略です。 |
| 2 | HTML | HTMLは、Hypertext Markup Languageの略です。 |
| 3 | CSS | CSSは、Cascading Style Sheetsの略です。 |
| 4 | 混在 | Test123 てすとアイウエオ 漢字！😊✨ |

---

## ⚡ Livewire Volt の特徴

### Functionalスタイルの採用
```php
<?php
use function Livewire\Volt\{state, mount, computed};

// 状態定義
state(['title', 'body', 'memos']);

// 初期化処理
mount(function () {
    $this->loadMemos();
});
?>
```

**メリット**: シンプルで直感的なコンポーネント開発

---

## 🎨 UI/UXデザイン

### デザインシステム
- **CSS Framework**: TailwindCSS
- **コンポーネントライブラリ**: Livewire Flux
- **レスポンシブデザイン**: モバイルファースト
- **アクセシビリティ**: WCAG準拠

### 主要機能
- リアルタイムバリデーション
- インタラクティブなUI
- ローディング状態管理

---

## 🔐 セキュリティ機能

### 認証・認可
- **認証システム**: Laravel Starter Kit
- **セッション管理**: 安全なセッション制御
- **CSRF対策**: 自動トークン付与
- **XSS対策**: エスケープ処理

### データ保護
- **入力値サニタイズ**: 自動実行
- **SQLインジェクション対策**: Eloquent ORM使用

---

## 🧪 品質保証

### テスト戦略
- **フレームワーク**: Pest (PHPUnit互換)
- **テストカバレッジ目標**: 70%以上
- **テスト種類**:
  - 単体テスト (Unit)
  - 機能テスト (Feature)
  - コンポーネントテスト (Livewire)

---

## 📁 プロジェクト構造

```
ai_memo_app/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   └── Memo.php
│   └── Livewire/Actions/
├── resources/views/livewire/
│   ├── auth/          # 認証関連
│   └── settings/      # 設定関連
├── database/
│   ├── migrations/
│   └── seeders/
└── tests/
```

---

## 🚀 開発環境

### セットアップコマンド
```bash
# 環境構築
./vendor/bin/sail up -d

# マイグレーション実行
./vendor/bin/sail artisan migrate

# シーダー実行
./vendor/bin/sail artisan db:seed

# テスト実行
./vendor/bin/sail artisan test
```

---

## 📊 パフォーマンス最適化

### 実装済み最適化
- **Eloquent ORM**: N+1問題の回避
- **インデックス設定**: user_idにインデックス
- **キャッシュ戦略**: Laravel標準キャッシュ
- **アセット最適化**: Vite使用

### 計画中の最適化
- **ページネーション**: 大量データ対応
- **検索機能**: 全文検索実装
- **APIキャッシュ**: Redis導入検討

---

## 🔮 今後の拡張計画

### Phase 1: 基本機能実装
- ✅ データベース設計
- ✅ モデル作成
- 🔄 CRUD操作実装
- 🔄 認証機能連携

### Phase 2: 高度な機能
- 📝 メモ検索機能
- 🏷️ タグ機能
- 📊 カテゴリ管理
- 💾 お気に入り機能

---

## 🎯 開発方針

### コーディング規約
- **PSR-12準拠**: 統一されたコードスタイル
- **型安全**: strict_types=1の徹底
- **日本語コメント**: 可読性重視
- **PHPDoc**: 完全なドキュメント化

### 開発プロセス
- **TDD**: テスト駆動開発
- **Git Flow**: 機能ブランチ戦略
- **コードレビュー**: 品質担保

---

## 📈 プロジェクトの価値

### 技術的価値
- **モダンPHP**: 最新PHP 8.4+の活用
- **リアクティブUI**: Livewire Voltの実践
- **型安全**: 厳密な型システム
- **テスト文化**: 高品質なコード

### ビジネス価値
- **高速開発**: Livewire Voltによる生産性向上
- **保守性**: 明確なアーキテクチャ
- **拡張性**: スケーラブルな設計

---

## ✨ まとめ

### 技術的ハイライト
- **Laravel 12.x + Livewire Volt**: 最新技術スタックの採用
- **Functional Volt**: シンプルで保守しやすいコンポーネント
- **型安全**: PHP 8.4+の厳密な型システム
- **品質保証**: Pestによる包括的テスト

### プロジェクトの強み
- 🚀 **高速開発**: モダンな開発環境
- 🔒 **高セキュリティ**: Laravelの堅牢なセキュリティ
- 📱 **レスポンシブ**: モバイル対応UI
- 🧪 **高品質**: TDD + 型安全な実装

---

## 🙏 ありがとうございました

### 質疑応答
- 技術的な詳細について
- 実装方針について
- 今後の拡張計画について

**Contact**: 開発チーム
**Repository**: ai_memo_app
