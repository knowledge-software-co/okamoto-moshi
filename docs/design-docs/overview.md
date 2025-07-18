### Design Docsとは

#### 参考

- [GoogleのDesign Docsから学ぶソフトウェア設計 - Qiita](https://qiita.com/yoshii0110/items/32f93e0c8d24cb3207f7)
- [Design Docの書き方 - Zenn](https://zenn.dev/shimakaze_soft/scraps/7a8170927a30cd)
- [Design Doc の書き方 - speakerdeck](https://speakerdeck.com/munetoshi/how-to-write-a-design-doc-ja-ver-dot)
- [プロダクトマネージャーの必須スキル: デザインドックの書き方 - Design Doc](https://note.com/kosukemori/n/n968cd16c53eb)


# 設計ドキュメント：中学受験模擬試験運営システム

---

## 1. 概要  
本ドキュメントは、以下の技術スタック／環境を前提に、中学受験模擬試験運営システムの技術設計をまとめたものです。  
- **サーバーサイド**：PHP8, Laravel12  
- **フロントエンド**：JavaScript, Vue.js, Laravel Inertia, Node.js, Tailwind CSS  
- **ダッシュボード UI**：Shadcn/Vue, Tailwind UI  
- **開発環境**：Docker, Laravel Sail, ngrok, MinIO（ファイルストレージ）  
- **本番インフラ**：AWS（EC2, RDS, S3, ElastiCache ほか）  
- **監視/分析**：Laravel Nightwatch, Sentry, Laravel Horizon  
- **検索**：Meilisearch, MySQL FULLTEXT + laravel‑cross‑eloquent‑search  
- **テスト/CI**：Pest, Vitest, Dusk, GitHub Actions, OpenAPI(Scribe) ほか  

---

## 2. 全体アーキテクチャ  

```plaintext
[ Vue.js + Inertia ]        [ API Docs (OpenAPI/Scribe) ]
         │                              ▲
         ▼                              │
[ Shadcn/Vue Dashboard ]  ←→  [ Laravel12 (API) ]  ←→  [ MySQL ]
         │                              │                 ├─ Redis (cache/model-caching)
         │                              │                 ├─ Meilisearch
         │                              │                 └─ S3 / MinIO (file storage)
         ▼                              │
     [ Laravel Horizon ]               │
         │                              │
         ▼                              │
  [ Nightwatch (監視) ]                 │
         │                              │
         ▼                              │
      [ Sentry ]                        │
```

---

## 3. コンポーネント設計  

### 3.1 サーバーサイド（Laravel 12）  
- **認証／権限管理**：Laravel Breeze or Laravel Jetstream + Sanctum  
- **ドメイン層**：Service → Repository → Eloquent Model  
- **ファイル管理**：Storage ファサード → 本番は S3、開発は MinIO  
- **キュー処理**：デフォルトキュードライバ（Redis） + Laravel Horizon で監視  
- **全文検索**：  
  - 主要件 → Meilisearch ライブラリ統合  
  - サブ要件 → MySQL FULLTEXT + protonemedia/laravel-cross-eloquent-search  
- **キャッシュ最適化**：genealabs/laravel-model-caching  
- **PDF生成**：Laravel Snappy or Dompdf（受験票／成績表）  
- **API ドキュメント**：Scribe で OpenAPI 定義を自動生成  

### 3.2 フロントエンド（Vue.js + Inertia）  
- **ページ構成**：  
  - SPA ルーティング via Inertia  
  - 各ビューは Vue コンポーネント化  
- **スタイリング**：  
  - Tailwind CSS  
  - Shadcn/Vue + Tailwind UI コンポーネント活用  
- **状態管理**：  
  - Inertia の props / page スコープ  
  - 必要に応じて Pinia  

### 3.3 ダッシュボード UI  
- **コンポーネントライブラリ**：Shadcn/Vue + Tailwind UI  
- **チャート／グリッド**：Recharts or Vue Chart.js  
- **フォーム & テーブル**：Headless UI + shadcn/form, shadcn/table  

---

## 4. 開発／デプロイパイプライン  

### 4.1 ローカル開発環境  
- Docker + Laravel Sail  
- ngrok で外部トンネル（API テスト／Webhook）  
- MinIO を Docker コンテナで emulate S3  
- `.env.example` → `.env` にコピー／鍵設定  

### 4.2 CI/CD (GitHub Actions)  
1. **プルリクエスト作成時**  
   - PHPStan(Larastan) + PHPMD + Pint + phpcs  
   - ESLint + Prettier  
   - Unit Tests (Pest) + Vitest  
   - Static API Schema Validation (OpenAPI Lint)  
2. **マージ後**  
   - ブランチビルド → Docker イメージ作成 → ECR プッシュ  
   - ECS/EKS へ自動デプロイ  
   - Database Migration via Laravel Envoy or GitHub Actions  

---

## 5. モニタリング／ログ／アラート  

- **エラー監視**：Sentry（PHP, JS）  
- **パフォーマンスプロファイリング**：Laravel XHProf + Telescope / Clockwork  
- **キュー監視**：Laravel Horizon ダッシュボード  
- **アクセス・エラー ログ**：AWS CloudWatch Logs  
- **ログビューア**：opcodesio/log‑viewer for ローカル確認  
- **Nightwatch**：定期的なエンドツーエンド監視  

---

## 6. キャッシュ & セッション  

- **キャッシュ**：Redis + `genealabs/laravel-model-caching`  
- **セッション**：Redis ドライバ  
- **Laravel preventLazyLoading**：N+1 チェック本番有効  

---

## 7. テスト戦略  

| 種別                   | ツール／内容                                                              |
|----------------------|-------------------------------------------------------------------------|
| 静的解析                | Laravel Pint, phpcs, PHPMD, PHPStan(Larastan), eslint, duster            |
| 単体テスト（バックエンド）    | Pest（モデル・サービス単位）                                              |
| 単体テスト（フロントエンド）  | Vitest + Vue Test Utils                                                    |
| 統合テスト               | Pest + HTTP テスト                                                          |
| ブラウザテスト             | Laravel Dusk, Selenium                                                     |
| 負荷テスト               | Taurus, Stressless(Pest Plugin)                                            |
| コンポーネント／UI ドキュメント | StoryBook + Chromatic                                                      |
| API ドキュメント／検証       | OpenAPI(Scribe) 自動生成 + Swagger UI                                     |
| N+1 検出               | preventLazyLoading function                                                |

---

## 8. セキュリティ  

- TLS 1.2+ 強制  
- WAF (AWS WAF) 設置  
- Sentry で例外キャプチャ  
- IAM ロール最小権限  
- Secrets 管理：AWS Parameter Store or Secrets Manager  
- Dependabot / Renovate で依存性アップデート  
- 定期ペネトレーションテスト  

---

## 9. バックアップ & DR  

- RDS スナップショット（自動／手動）  
- S3 バージョニング + ライフサイクルルール  
- 定期的なインフラ構成バックアップ (Terraform state 管理)  

---

## 10. 運用・保守  

- **ドキュメント**：各サービス README + ADR (Architecture Decision Records)  
- **オンコール**：PagerDuty 連携  
- **ナレッジ共有**：Confluence + Slack 通知  
- **定期レビュー**：セキュリティ／コスト／パフォーマンス四半期ミーティング
