# 🐛 テスト失敗時のデバッグ方法（PHP静的解析） - Static Code Analysis (PHP)

## `PHP-CS-Fixer` エラー

### `Tighten/custom_ordered_class_elements` エラー

- `./php-cs-fixer.php` ファイルの `setRules['Tighten/custom_ordered_class_elements']` 内参照

### `Tighten/custom_phpunit_order` エラー

テストメソッドが特定の順序で配置されることを要求します。<br>
以下の順序が推奨されます。

1. setUp メソッド
1. テストメソッド（アルファベット順）
1. ヘルパーメソッド
