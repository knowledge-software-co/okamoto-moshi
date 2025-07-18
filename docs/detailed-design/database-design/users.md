# 🕺 ユーザーテーブル設計

## テストデータ生成

### ユニークなメールアドレスを生成する

- Fakerでつくられるemailアドレスは重複の可能性があるので、自前で実装する

#### 参考

- [PHP Fakerの safeEmail の中身を覗いてみた（重複エラーの回避方法もあるよ） - Zenn](https://zenn.dev/asuene/articles/5e21fce10b0734)

## 主キーをImplicit Bindingしないようにする

Auto Incrementされた主キーをImplicit Bindingすることで様々なデメリットが発生する。

1. システムの規模が露呈する
2. URLを変更するだけで他データにアクセスされてしまう

そのため、Auto Incrementされた主キーを隠す目的で、別途生成したULIDをImplicit Bindingする。

### 参考

- [LaravelでIDを隠す方法](https://www.php.cn/ja/faq/523339.html)
- [MySQLでUUIDv4をプライマリキーにするとパフォーマンス問題が起きるのはなぜ？（N回目） - zenn](https://zenn.dev/reiwatravel/articles/9ce1050bf8509b)
- [Laravel UUID、ULID で遊んでみる - zenn](https://zenn.dev/nshiro/articles/07b1e4834b9214)
- [Laravel でテーブルの ID を ULID に指定する方法 - zenn](https://zenn.dev/azuki_penguin/articles/59715b43ef3b70)
- [getRouteKeyNameメソッドでLaravelのURLをID以外にする方法 - Qiita](https://qiita.com/phper_sugiyama/items/bdeee931ae2b821af895)
- [［Laravel］Implicit BindingとgetRouteKeyName() メソッドについて - Qiita](https://qiita.com/Tomochan_taco/items/2fd550a73f7a05252304)

## roleごとにユニークな番号を付与する

### 参考
[Laravel で連番／シーケンスを作るテクニック （採番テーブルの作り方）](https://qiita.com/kd9951/items/5b2f55e13a4da0f33b6b)
