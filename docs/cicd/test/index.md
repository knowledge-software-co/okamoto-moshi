# 🏷️ テスト自動化 - Test Automation

## 📝 概要 - Overview

テストは、ソフトウェアの品質を保証するために重要な要素です。<br>
本ソフトウェアでは、以下のテスト自動化に取り組むことで品質を保ちつつ開発を行います。

> [!TIP]
> 基本的には、バックエンドの機能テスト（Featureテスト）を実装してください。<br>
> [「なんちゃってクリーンアーキテクチャ」でテストどうするの？](https://zenn.dev/mpyw/articles/ce7d09eb6d8117#%E3%83%86%E3%82%B9%E3%83%88%E3%81%A9%E3%81%86%E3%81%99%E3%82%8B%E3%81%AE%EF%BC%9F)<br>
> また、Actionsクラスのテストは、Inertia.jsのエンドポイントテストを実装してください。<br>
> [Testing - Inertia.js](https://inertiajs.com/testing#endpoint-tests)<br>
> テストカバレッジは80%を目指してください。<br>
><br>
> テストカバレッジは以下のコマンドで確認できます。<br>
> `./vendor/bin/sail php ./vendor/bin/pest --coverage --min=80` <br>
> `./vendor/bin/sail npm run test:coverage`

1. バックエンド
    1. 静的解析（Larastan(PHPStan)）
    1. Unitテスト - Unit Test
1. フロントエンド
    1. JavaScript静的解析 (ESlint)
    1. Unitテスト（Vitest）
1. E2Eテスト
    1. ブラウザテスト (`Laravel Dusk`)

## 以下コマンドで全て実行されます

> [!WARNING]
> `make test` を実行する前にViteのHMRは停止してください。

```bash
$ make test
```

## 参考

- [「なんちゃってクリーンアーキテクチャ」でテストどうするの？](https://zenn.dev/mpyw/articles/ce7d09eb6d8117#%E3%83%86%E3%82%B9%E3%83%88%E3%81%A9%E3%81%86%E3%81%99%E3%82%8B%E3%81%AE%EF%BC%9F)
- [テストカバレッジ100%を追求しても品質は高くならない理由と推奨されるカバレッジの目標値について - Qiita](https://qiita.com/odekekepeanuts/items/d02eb38e790b93f44728)

## 📋 目次 - Navigation

### バックエンド

- [🗒️ 静的解析（Larastan(PHPStan)） - Static Code Analysis](/docs/cicd/test/backend/static-code-analysis.md)
- [🧪 Unit & Featureテスト - Unit & Feature Test](/docs/cicd/test/backend/unit-feature-test.md)

### フロントエンド

- [🗒️ 静的解析 (ESlint) - Static Code Analysis](/docs/cicd/test/frontend/static-code-analysis.md)
- [🧪 Unitテスト & Feature（Vitest） - Unit & Feature Test](/docs/cicd/test/frontend/unit-feature-test.md)

### E2Eテスト

- [🌏 ブラウザテスト (`Laravel Dusk`) - Browser Test](/docs/cicd/test/e2e/browser-test.md)

### FAQ

- [🐛 テスト失敗時のデバッグ方法 - How to Debug](/docs/cicd/test/faq/how-to-debug.md)
- [🐛 ブラウザテスト失敗時のデバッグ方法（Laravel Dusk） - How to Debug](/docs/cicd/test/faq/browser-test.md)

## 考え方

### 「正しいテストが書けているか」はどのように保証しますか？

難しい問題だが、「テストコードは正しさを完全に証明するものではない」と捉えるべきです。<br>
テストコードに限らず完璧なコードを書くことは現実的には不可能です。<br>
となると、正しいと保証されていないテストコードを書く意味はあるのか？という問いになりますが、
結論「ある」と思います。主に以下の観点です。<br>

- テストコードを書くことで気が付かなかった仕様ミスや実装ミスに気が付ける
- テストコードは実装のドキュメントになり得る
- 何回も繰り返される動作確認を効率的に行える

完全ではないかもしれないが、それでも価値は高い。
あとはテストコードもちゃんと保守し続けると言う意識が開発チームに根付いていくことも重要になります。

- 参考: [E2Eテストで挫折しそう？ どうしているかを話してみた - YouTube](https://www.youtube.com/watch?v=3YlTpFCljNQ&t=1162s)
