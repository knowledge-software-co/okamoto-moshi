# 🖥️ 環境構築 - Installation

## 📝 前提条件

-   Dockerがインストールされていること（Windowsの場合、WSL2を使用してください。）
-   Dockerが起動していること
-   Gitがインストールされていること
-   Gitが設定されていること

## git clone後

> [!IMPORTANT]<br>
>
> ### 💻 ngrok
>
> LINE API, Stripe APIを利用するためにはSSL暗号化通信(httpsプロトコル)を使用する必要があります。<br>
> そのため、 [ngrok](https://ngrok.com/) というサービスを利用する必要があります。<br>
> まず、[ngrokのサイト](https://ngrok.com/)よりアカウントを作成してください。<br>
> その後、auth tokenを発行し、.env の NGROK_AUTHTOKEN に記入してください。<br>
> 　auth tokenは Setup & Installationページ（ログイン直後の画面）にあります。<br>
> 次に、ngrokのURLを固定し、.envのAPP_URL、NGROK_DOMAINに記入してください。<br>
> 　URLの固定方法は、Domainsより作成することで固定することができます。<br>
> （ngrokには月毎にネットワーク帯域幅の制限があります。制限に達するとERR_NGROK_725エラーが発生します。そのため、複数アカウントを利用することで、制限を回避することができます。）<br>
>
> ### 💳 Stripe
>
> サブスクリプションの決済サービスには[Stripe](https://stripe.com/jp)を使用しています。<br>
> また、LaravelとStripeの紐づけにはLaravel Cashierを使用しています。<br>
> そのため、開発環境では各個人で[Stripe](https://stripe.com/jp)のアカウントを作成してください。<br>
> その後、auth tokenを発行し、.env の STRIPE_KEY, STRIPE_SECRET, STRIPE_WEBHOOK_SECRET に記入してください。<br>
> 次に、ngrokで固定したURLをwebhook URLに登録してください。<br>
>
> また、上記で作成したStripeアカウント内で、サブスクリプション用の商品を作成する必要があります。（別途マニュアル作成中）<br>
> 作成した商品の `stripe_price_id` とそれに紐づく `stripe_key` を<br>
> `database/seeders/Test/TestServicePlansTableSeeder.php` に追記してください。<br>
>
> ### 💬 LINE
>
> LINE APIを利用するために、[LINE Business ID](https://account.line.biz/login)を作成してください。
> <br>

1. `.env.example` を `.env` にリネームしてください。
2. 上記 `💻 ngrok` と `💳 Stripe` と `💬 LINE` の設定を行ってください。

3. Windows: WLS2を使用し以下のコマンドを実行してください。<br>
   MacOS: 以下のコマンドを実行してください。

```bash
$ make init
```

参考:<br>
[Laravel Sailで作成したプロジェクトをGitHubリポジトリにpushして利用する](https://qiita.com/kai_kou/items/bfea0281689b3d376812)<br>
[git cloneしたLaravelプロジェクトをSailできるようにするためのスクリプト（やっつけ）](https://gist.github.com/niratama/b9611694f5f20d7819544a2399155cdc)

## 起動

```bash
$ make up
$ sail npm run dev
```

※上記コマンドを実行後、ngrokの固定URLにアクセスしてください

> [!IMPORTANT]<br>
> ブラウザにてアクセス後、画面が真っ白になりコンソールで net::ERR_CERT_AUTHORITY_INVALID エラーが出力されていた場合、エラーが出力されているファイルにブラウザでアクセスし、ブラウザのエラー画面より表示を許可してください。<br>
> その後ngrokのURLにアクセスすると画面が表示されるようになります。<br>
> <br>
> もしくは、/certs/signed.crt ファイルをブラウザまたはOSにインストールしてください。<br>
> MacOSの場合、キーチェーンアクセスを開き、インストールした.crtファイルを開き、信頼設定を変更してください。

## テスト用DB

```bash
$ cp .env .env.testing
```

make initで自動作成されます。

.env.testing

```
- DB_HOST=mysql
+ DB_HOST=mysql.test
```

APP_KEYを生成する

```bash
$ sail artisan key:generate --env=testing
```

## DBのマイグレーションとシーダー実行

各テーブルの構築とテストデータのInsertをします。

> [!IMPORTANT]<br>
> シーダーを実行すると、Stripe上に顧客データが作成されます。

```bash
$ make fresh

or

$ ./vendor/bin/sail artisan migrate:fresh --seed
```

## gitの設定について

改行コードの自動変更はOFFにしておくこと

・改行コード変更コマンド

```bash
$ git config --global core.autocrlf false
```

・変更後の確認

```bash
$ git config --global -l
```

## チームで共通のGit hookを使う

参考： https://www.farend.co.jp/blog/2020/04/git-hook/

.githooksディレクトリをHooksのコアディレクトリに指定

```bash
$ git config --local core.hooksPath .githooks
```

make initで自動実行されます。

## コミットメッセージ

コミットメッセージには、「見出し」「Issues番号」「作業時間」を記入してください。<br>
例） Add: :construction_worker: git hooksスクリプトを追加 (#1) @0.1h<br>
詳しくは .githooks/commit-msg を参照

## 🍺 その他コマンド

Makefileを参考にしてください。
Makefileはあくまでメモ程度にお考えください。

### Makefileとは

[【初心者向け】Makefile入門](https://qiita.com/mizcii/items/cfbd2aa17f6b7517c37f)

## Scribe

仕様書を生成（public/docs下に仕様書等が作成される）

```bash
$ ./vendor/bin/sail artisan scribe:generate
```

## SchemaSpy

DB設計書・RE図を生成（./schemaspy下に仕様書等が作成される）

```bash
$ ./vendor/bin/sail up schemaspy
```

## Laravel TypeScript

TypeScriptインターフェイスを生成します。

```bash
$ sail artisan typescript:generate
```
