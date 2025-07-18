# 🚚 CI/CD - Continuous Integration / Continuous Delivery

## Gitフック - Git Hooks

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
