# バッチ処理概要説明

## 用語

- キュー
    - 非同期処理を行うための待ち行列
- ジョブ
    - 実行したい処理
- ワーカー
    - ジョブを取り出す役割
- Supervisor（スーパーバイザー）
    - プロセス管理ツール。ジョブがエラーなりワーカーが落ちた際に再起動する役割がある。
    - `AWS Linux 2` では `Systemd` を使用するため、 `Supervisor` は使用しない。
    - また、 `Laravel Sail` では、 プロセス監視用のDockerコンテナを立ち上げるため利用しない。

## 仕様

### ローカル環境（Laravel Sail（Docker））

#### キュー

- [Laravel Horizon](https://readouble.com/laravel/10.x/ja/horizon.html)を使用した Redisキュー環境。

#### バッチ処理

以下を使用したバッチ処理環境。

- Cron
- Supervisor
- [Laravel Schedule](https://readouble.com/laravel/10.x/ja/scheduling.html)

### 本番環境（AWS Beanstalk）

#### キュー

- AWS SQSを使用したキュー環境。

#### バッチ処理

- `Amazon Linux 2` の `cron` を使用したバッチ処理環境。
- `Amazon Linux 2` 環境のため、`Supervisor` が不要。 `Systemd` を使用したバッチ処理環境。
