# 📐 技術選定 - Technology Selection

## バックエンド

- PHP - PSR-4、PSR-12に準拠

### フォルダ構成

- DDDやクリーンアーキテクチャを参考に、UseCase層のみを用いた構成<br>
(UserCase層については、 `app\Http\UserCase` ディレクトリに格納)

#### 参考

- [5年間 Laravel を使って辿り着いた，全然頑張らない「なんちゃってクリーンアーキテクチャ」という落としどころ](https://zenn.dev/mpyw/articles/ce7d09eb6d8117)
- [LaravelのActionと使い方](https://www.fourier.jp/techblog/articles/how-to-use-laravel-action/)
- [どっちのディレクトリ構造が良い？](https://x.com/dumblepytech1/status/1148432073960480768)
- [ざっくりDDD・クリーンアーキテクチャにおける各層の責務を理解したい①（ドメイン層・ユースケース層編）](https://qiita.com/kotobuki5991/items/22712c7d761c659a784f)
- [「サービスクラス」は 3 種類ある](https://www.kanzennirikaisita.com/posts/what-is-service-class)

### クリーンコード

クリーンコードを意識してください。

- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices/blob/master/japanese.md)
- [クリーンコードを目指すためのコメントの書き方ガイド](https://note.com/yonemori550/n/n7dff8267ab26)

## フロントエンド

- Vue.js - インデントはスペース4つ (Laravelインストール時の.vueファイルがスペース4つのため)

### 参考

- [【React/Vue.js】コンポーネント設計の（個人的）ベストプラクティス | Offers Tech Blog](https://zenn.dev/offers/articles/20220523-component-design-best-practice)
- [フロントエンドのコンポーネント設計において参考になる記事まとめ](https://zenn.dev/toshiyuki/articles/ea9fabc073ea0c)
