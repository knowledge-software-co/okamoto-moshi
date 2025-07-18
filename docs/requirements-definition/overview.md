# 🏁 概要 - Overview

Cuvra はLINE botシステム用のLaravelプロジェクトです。<br>
LINE APIを使用し、Webシステム上でLINEリッチメニューの作成や<br>
それに伴う機能を提供します。

## システム構成図

- 開発環境はDockerを使用
- ソースコードの管理はGithubを使用
- CI/CDパイプラインはGithub Actionsを使用
- 本番環境はAWS Beanstalkを使用

```mermaid
flowchart TD;
    subgraph "AWS Beanstalk"
        EC2["EC2 Instance"];
        RDS["RDS Database"];
        S3["S3 Bucket"];
        subgraph "PHP, Laravel"
            PHP["PHP Application"];
            Laravel["Laravel Framework"];
        end
    end
    GitHub["GitHub Repository"];
    GitHub --> EC2;
    GitHub --> RDS;
    GitHub --> S3;
    EC2 --> RDS;
    EC2 --> S3;
    EC2 --> PHP;
    PHP --> Laravel;
```

## 背景

以前より構想していたLINEマーケティングツールを形にするべく、2023年より開発開始。

## 定義

専門用語の定義はここに記述する。

- オーナー: LINEアカウントを運用する個人・企業。運営者はオーナーから料金を受け取る。
