# 🌏 ブラウザテスト (`Laravel Dusk`) - Browser Test

> [!WARNING]
> `Laravel Dusk` を実行する前に `Vite` のHMRは停止してください。<br>
> （`./vendor/bin/sail npm run dev` の停止）<br>
> <br>
> また、`Vite` のHMRを停止するため、事前に `./vendor/bin/sail npm run build` を実行してビルドしてください。

> [!WARNING]
> `Laravel Dusk` では、`ngrok` の通信量を多く使います。通信量制限に注意してください。<br>
> `ngrok` を複数アカウントで運用する際、アカウントごとに `ngrok` の `authtoken` と `URL` を設定してください。<br>
> また、`.env` の内容を編集した際は、`./vendor/bin/sail down` でコンテナを停止し、`./vendor/bin/sail up -d` でコンテナを再起動してください。（`ngrok` のURLが反映されないため）<br>
> その後、`.env` のキャッシュを削除するため、`./vendor/bin/sail artisan config:clear` を実行してください。

```bash
$ ./vendor/bin/sail dusk
```

### `Laravel Dusk` の実行に時間がかかるときの注意

テスト実行中に、手動で強制終了することは避けてください。

理由：

- テスト実行中は一時的なテスト用 .env ファイルが生成されます。
- 強制終了すると、この一時ファイルが不完全な状態で残る可能性があります。
- 結果として、以降のテストや操作が誤った環境設定で実行される危険性があります。

- [🐛 テスト失敗時のデバッグ方法（ブラウザ） - How to Debug](/docs/cicd/test/faq/browser-test.md)
