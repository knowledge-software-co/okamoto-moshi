# デバッグ方法

## 1. ログの活用

Laravelのログファイルは `storage/logs/laravel.log` に保存されます。エラーや警告メッセージを確認するには、このファイルを定期的にチェックしてください。<br>
また、ログファイルを確認しやすくするため、`opcodesio/log-viewer` を導入しています。`https://[ngrok_uri]/log-viewer` にアクセスして確認してください。

## 2. デバッグ用の各ツール

- opcodesio/log-viewer
    - `https://[ngrok_uri]/log-viewer`
- Clockwork
    - [Clockwork - Chrome ウェブストア](https://chromewebstore.google.com/detail/clockwork/dmggabnehkmmfmdffgajcflpdjlnoemp?hl=ja)
    - [LaravelのAPI開発でデバッグする方法](https://r-app.jp/laravel-api-debug/)
- Vue.js devtools
    - [Vue.js devtools - Chrome ウェブストア](https://chromewebstore.google.com/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd?hl=ja)
    - [Vue.js devtoolsの使い方まとめ](https://qiita.com/haykubo/items/fce1674365b2b622c70c)
