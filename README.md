# Okamoto Moshi

Knowledge Software Co.'s internal portal system

## About Okamoto Moshi

Okamoto Moshiは株式会社岡本カンパニーの模試管理システムです。<br>
このプロジェクトは VILT Stack (Laravel + Inertia.js + Vue.js + Tailwind CSS) によるモノリス且つモノレポ構成となっています。<br>

## 📄 ドキュメント - Documents

- 📝 [プロダクト要求仕様書(PRD)](/docs/prd/index.md)
- 📝 [要求定義](/docs/requirements/index.md)
- 📝 [要件定義](/docs/requirements-definition/index.md)
- 📝 [基本設計](/docs/basic-design/index.md)
- 📝 [詳細設計](/docs/detailed-design/index.md)
- 📝 [テスト](/docs/testing/index.md)
- 🏁 [Design Doc](/docs/design-docs/overview.md)
- 🚚 [CI/CD](/docs/cicd/index.md)
- 🖥️ [スタートガイド](/docs/start-guide/index.md)

## 🛠️ 使用技術

### 環境

- サーバーサイド(PHP8, Laravel12)
- フロントエンド(JavaScript, Vue.js, Laravel Inertia, Node.js, Tailwind CSS)
- ダッシュボードフレームワーク(Shadcn/Vue, Tailwind UI)
- 開発開発(Docker, Laravel Sail, ngrok)
- 開発環境ファイルストレージ(MinIO)
- 本番環境インフラ(AWS)
- 本番環境ファイルストレージ(AWS S3)
- 本番環境サーバー監視・分析([Laravel nightwatch](https://nightwatch.laravel.com/))
- データベース(MySQL)
- キャッシュ(redis, genealabs/laravel-model-caching)
- エラー検知(Sentry)
- キューモニタリング（Laravel Horizon）
- 全文検索（Meilisearch, MySQL FULLTEXT INDEX + protonemedia/laravel-cross-eloquent-search）
- 決済(Laravel Cashier, Stripe)

### テスト・解析

- 静的解析(Laravel Pint, phpcs, PHPMD, php intelephense, PHPStan(Larastan), tightenco/duster, ESLint)
- フォーマッター(Prettier)
- バックエンド単体・統合テスト(Pest)
- フロントエンド単体・統合テスト(Vue Test Utils, Vitest)
- ブラウザテスト(Selenium, Laravel Dusk, Pest)
- CI/CD(Git hooks, GitHub Actions)
- API スキーマ定義(OpenAPI, Swagger, Laravel API Documentation Generator, Scribe)
- UI 検証(StoryBook & Chromatic - StoryBookホスティングサービス)
- 負荷テスト(Taurus, Stressless(Pest Plugin))
- プロファイリング（Laravel XHProf）
- N+1チェック（Laravel preventLazyLoading function）
- ログビューワ（opcodesio/log-viewer）
- 開発用デバッグツール（Laravel Telescope, Clockwork）

### UX/UI

- CSSフレームワーク(Tailwind CSS, Tailwind UI)
- デザインツール(Figma, draw.io, PlantUML, Mermaid)
- SVGアイコン(tailwindlabs/heroicons)
- コンポーネント(shadcn/vue)
- Webアニメーション(Lottie.js, GSAP)
- フロントエンドコンポーネント管理(Storybook)
- ステートマシン（状態遷移）管理(asantibanez/laravel-eloquent-state-machines)

### SEO

- XMLサイトマップ（spatie/laravel-sitemap）

### Vue.js Library

- VueUse
- Vueform
- notiwind
- tailwindlabs/heroicons
- Sopamo/laravel-filepond
- Vue 3 Multiselect - vueform/multiselect

### Laravel Packages

- Laravel Sail
- Laravel Jetstream
- Laravel Inertia
- Laravel Telescope
- Laravel Pulse
- ziggy
- Clockwork
- DataTables
- bensampo/laravel-enum
- Laravel sushi
- spatie/laravel-tags（タグ分け）
- spatie/laravel-permission（ロールベースアクセス制御(RBAC)）
- lazychaser/laravel-nestedset（入れ子集合モデル）
- asantibanez/laravel-eloquent-state-machines（ステートマシン（状態遷移）管理）
- GeneaLabs/laravel-model-caching (Cache)
- emargareten/inertia-modal（モーダル）

### CI/CD

- GitHub Actions
- Git hooks
- laravel/envoy

### その他ツール

- モジュールバンドラー(Vite)
- バージョン管理(Git/GitHub)
- タスク管理(ClickUp or redmine)
- コードエディタ(VSCode)
- 画面遷移図(guiflow, PlantUML, Mermaid)
- DB設計書・ER図(SchemaSpy, PlantUML, Mermaid)
- 商品お気に入り登録(Laravel Markable)
- ソーシャルログイン(Laravel Socialite)
- 入れ子集合モデル（lazychaser/laravel-nestedset）
- ロールベースアクセス制御(RBAC)（laravel-permission）
- APIドキュメント（knuckleswtf/scribe, dedoc/scramble）

### Documents

- 画面遷移図: /docs/screen-transition-diagram.plantuml
- ER図: /docs/er-diagram.plantuml and http://localhost:8080 (SchemaSpy) （自動生成）
- API仕様書: http://localhost:8002 (SwaggerAPI) or http://localhost/docs (Scribe, dedoc/scramble)（自動生成）
- インフラ構成図: /docs/infra.plantuml

### 各種URL

> [!IMPORTANT]
> ngrokを使用しているため、localhostは一部ngrokのURLに変更されます。

- https://[ngrok_uri] (Laravel)
- https://[ngrok_uri]/up (Laravel Health Check)
- https://[ngrok_uri]/clockwork (Clockwork)
- https://[ngrok_uri]/telescope (Telescope)
- https://[ngrok_uri]/horizon (Horizon)
- https://[ngrok_uri]/pulse (Pulse)
- https://[ngrok_uri]/log-viewer (log-viewer)
- https://[ngrok_uri]/docs/api (Scribe)
- http://localhost:4040 (ngrok)
- http://localhost:7700 (Meilisearch)
- http://localhost:8001 (Swagger Editor)
- http://localhost:8002 (SwaggerAPI)
- http://localhost:8025 (mailhog)
- http://localhost:8080 (SchemaSpy)
- http://localhost:8900 (MinIO)
- http://localhost:9002 (Storybook)
