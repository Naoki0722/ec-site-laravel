<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Dockerを使ってLaravelの開発環境を構築

こちらのrepositoryでは、Laravelの開発環境をDockerで構築する手順を記す。
すでにプロジェクトファイルはローカルで作成していたため、プロジェクトディレクトリを移植した。
<br>
<br>

## 構築手順
***
dockerはインストールしている前提で進める。

```
matsunoMBP:docker-laravel-ec naoki$ docker -v
Docker version 20.10.2, build 2291f61
```
<br>

### 1.イメージやDockerfileを使ってビルド
***

- 下記コマンドでまだイメージが作成されていなければ、イメージを作成して、さらにコンテナを作成・起動します。
- もし、すでにコンテナが存在すれば、イメージ・コンテナの再作成は行わず、（停止中の）コンテナを起動するだけです
- -dがないとバックグラウンドで起動できないので入力忘れに注意！

```
docker-compose up -d
```

dockerアプリで起動していることを確認する
<br><br>

### 2.Laravelインストール
***
Dockerfileにてcomposerのインストール済みであるため、composerのインストール確認をする。

まずは、phpコンテナに入る。(phpとはアプリ名を指す)
```
docker-compose exec php bash
```

コンテナに入った後

```
root@d1138847703d:/var/www/html/# composer --version
```

バージョン確認できたら、Laraveのインストールを実施。(ver.8でインストール)
```
composer create-project --prefer-dist "laravel/laravel=8.*" travel-app[お好きなアプリ名を入力]
```
<br>

### 3.LaravelとMySQLの接続
***
Laravleでの開発が行えるようにMySQLとの接続を設定します。

エディターでlaravel-appを開いて.envを開きます。

まずは`docker-compose.yml`を確認する。
```
db:
    image: mysql:5.7
    ports:
      - '3306:3306'
    environment:
      MYSQL_DATABASE: db_name
      MYSQL_USER: db_user
      MYSQL_PASSWORD: db_password
```

Laravelの`.env`を下記で入力

```
DB_CONNECTION=mysql
DB_HOST=db（←コンテナ名）
DB_PORT=3306（←コンテナ側のポート番号）
DB_DATABASE=db_name
DB_USERNAME=db_user
DB_PASSWORD=db_password
```
<br>

### 4.MySQLの認証方法変更
***

MySQL8.0で使う場合は、MySQL 8〜ではデフォルトの認証方法が変更になっているようです。

まずは、MySQLコンテナに入り、MySQLにログイン
```
docker-compose exec mysql bash
mysql -u root -p
```

データベースの切り替え、ユーザーごとの認証方式を確認する。
```
mysql> use mysql
mysql> select user, host, plugin from user;
+------------------+-----------+-----------------------+
| user             | host      | plugin                |
+------------------+-----------+-----------------------+
| hoge             | localhost | caching_sha2_password |
| mysql.infoschema | localhost | caching_sha2_password |
| mysql.session    | localhost | caching_sha2_password |
| mysql.sys        | localhost | caching_sha2_password |
| root             | localhost | caching_sha2_password |
+------------------+-----------+-----------------------+
```

この場合、hogeで認証がうまくいっていない.

hogeの認証方法を変更します。
```
mysql> alter user 'hoge'@'localhost' identified with mysql_native_password by 'ここにパスワード';
```

プラグインが「mysql_native_password」になれば成功
<br>
<br>



## 接続確認
***
phpコンテナのLaravelプロジェクトで動かす

```
php artisan serve --host 0.0.0.0
```

マイグレーションが問題ないかも確認する。
```
php artisan migrate
```
<br>

## コンテナ停止
***

```
docker-compose down
```


# 20210125 コードレビュー依頼

作成後初めてのコードレビュー依頼となります。

仕様書(スプレッドシート)で記載していたAPIは一通り作成いたしました。

(StripeのCheckout決済のためのSessionID作成のAPIも作成しています)

※管理者権限のことはまだ実装していません。作るAPIの追加としては商品登録と削除の機能かと思いますので、StoreとDestroyを作れば終わりかと思います。

## 確認いただきたい箇所

### その1
今回みていただきたい箇所は、CartsController.phpとLikesController.phpのStoreアクションです。

単純に$requestに対するレコードを作成すればいいのですが、idをユニークにしているので
user_idやproduct_idが重複してもインサートされてしまい、id違いの同じデータのレコードが複数できてしまいます。

これを制御するには下記のようなif文で組んでみようかと思ったんですが、今の構文で良いか自信がないです。

もしくはフロント側で同じ商品に対してカートに入れようとしたりお気に入りしたりしようとした際にalertで弾きたいです。

### その2
一部クエリビルダやDB::rawを使って生クエリを使っているのでコードが汚いように思います。。。

Laravelなら、Eloquentの書き方で統一した方がよろしいでしょうか？


##　その他(補足)
その他Controllerも作成していますので合わせてご確認よろしくお願いいたします。

(もし、テストする場合は、必要に応じてローカルテストできるようダミーデータとしていくつかシーディングファイルを作っております)

ご確認よろしくお願いいたします。


# 20210128 2回目コードレビュー依頼

Modelを使ったリレーションに変更(勉強のため)

全てのAPIは作成完了、商品登録(画像アップロード)は後ほど。

php ユニットテストの勉強に着手することとする。





# 20210131 現状の実装

PHPunitを用いたテストコードを実装した。

DBについては、テストコード用のローカルDBを用意。
DB変更については、phpunit.xmlではなく.env.testingを別に用意して対応。


すべてのテストについては未実施。(あくまでテストコードについての勉強の位置付け)



APIのレスポンス確認がメインであるため、単体テストではなく、機能面のフューチャーテストのみとなる。


# 20210228 実装

管理者ができる機能を実装した。

主に下記の機能

1. 商品登録
2. 商品削除
3. 商品編集

しかし、今回の機能は管理者以外ができてしまうとリスクがあるため、認可の機能を入れている。

認証自体はfirebaseに任せているため、認証後のtokenをバックエンドに送信。


送信されたtokenの妥当性をバックエンドで確認し、uidを取得する。今回よりusersテーブルにはuidを格納するuser_idのカラムを追加した。

また、権限としてroleというカラムを追加。role=5は管理者とし、role=10はユーザーとした。

user_idに一致するroleをみて、管理者かユーザーかを判別することとし、その判別をミドルウェアに登録した。

ミドルウェアを通過するルーティングで管理者であれば通し、ユーザーなら弾くという処理を実装している。

また、フロントエンドでパスワードリセットの処理をfirebaseで入れることからDBへパスワードの格納は取りやめた。(本来認証はfirebaseでするべきであり、個人情報であるパスワードを下手にDBに格納する必要性を感じなかったため。)