# 🏞️ Gitについて - Git

## Gitフロー - Git Flow

Git-flowを採用。
「master」「develop」以外のサポートブランチは、「user/〇〇」を使用します。

### 参考

- [Gitブランチフロー規約の紹介](https://future-architect.github.io/articles/20241214a/)
- [結局 Git のブランチ戦略ってどうすればいいの？ - Qiita](https://qiita.com/ucan-lab/items/371cdbaa2490817a6e2a)

## コードレビューについて

コードレビューを受けたい場合、「Draft PR（Draft Pull Request）」を利用してください。

- [GitHubのコードレビューを受ける際に気をつける事](https://zenn.dev/keitakn/articles/github-code-review-reviewee)
- [WIPの代わりにDraft Pull Requestを利用する (GitHub)](https://qiita.com/tatane616/items/13da1b6797a7b871ad58)

## Gitフック - Git Hooks

### コミットメッセージ

（要検討）

```
構文:
    [Prefix] <Message body> <ticket_no> <working_hours>
見出しとして使えるもの:
    追加: または add:
    修正: または fix:
    改善: または improve:
    更新: または update:
    削除: または remove:
    改名: または rename:
    移動: または move:
    交換: または change:
```

## GitHubアクション - Github Actions

（要検討）

以下をgit push後、pull request後、merge後に実行
```bash
$ ./vendor/bin/sail php ./vendor/bin/pest
$ ./vendor/bin/sail dusk
$ ./vendor/bin/sail php ./vendor/bin/phpstan analyse -c phpstan.neon
```
