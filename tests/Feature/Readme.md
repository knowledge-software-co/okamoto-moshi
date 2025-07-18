# フューチャーテスト（機能テスト）について

## フューチャーテストとは

フューチャーテスト（機能テスト）は、アプリケーションの機能をテストするためのテスト手法です。

## 当プロジェクトにおけフューチャーテスト

当プロジェクトは「なんちゃってクリーンアーキテクチャ」を参考にクラス設計をしています。<br>
そのため、フューチャーテストを中心にテストを行っています。<br>

> [「なんちゃってクリーンアーキテクチャ」でテストどうするの？](https://zenn.dev/mpyw/articles/ce7d09eb6d8117#%E3%83%86%E3%82%B9%E3%83%88%E3%81%A9%E3%81%86%E3%81%99%E3%82%8B%E3%81%AE%EF%BC%9F)<br>

### [テスト観点](https://service.shiftinc.jp/column/5029/)について

当プロジェクトでは、以下の観点でフューチャーテストを行っています。

- [エンドポイント](https://kinsta.com/jp/knowledgebase/api-endpoint/)のアクセスに対し、正しいレスポンスが返ってくるかを確認します。

### ディレクトリ構成について

- テストクラスは、`tests/Feature`ディレクトリに配置しています。
- 各クラスに対応したディレクトリにテストクラスを配置しています。
- テストクラスは、テスト対象のクラス名の末尾にTestを付けたクラス名にしています。

## テストの実行方法

```bash
$ task test

# または

$ ./vendor/bin/sail artisan config:clear
$ ./vendor/bin/sail artisan migrate:fresh --seed --env=testing
$ ./vendor/bin/sail php ./vendor/bin/pest
```

### その他

その他詳細はこちらを参考にしてください。<br>
[テスト - testing](/docs/testing/index.md)
