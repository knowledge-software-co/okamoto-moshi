# 🐛 テスト失敗時のデバッグ方法 - How to Debug

## テスト失敗時のデバッグ方法

### 環境設定の確認方法

現在の環境設定に疑問がある場合は、以下のコマンドで確認してください。

```bash
$ ./vendor/bin/sail php artisan env
```

正常な出力例：

```
   INFO  The application environment is [local].
```
各自のマシン内などのローカル開発環境では `local` が正しいです。
