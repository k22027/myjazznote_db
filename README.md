# 「MyJazzNote」を実行するために

## 1.最初に

#### 1.1 zipファイルを~/htdocs/で解凍する

#### 1.2 初期化スクリプト(jazzdb_create.sql)をmysqlで使用する

    /Applications/XAMPP/xamppfiles/bin/mysql -u root -p < /Applications/XAMPP/xamppfiles/htdocs/jazzdb_create.sql  

## 2.テスト用アカウントログイン方法
（テスト用でなくてもlocalhost/index.phpから動きますが，曲を自分で追加するまで一覧やおすすめに曲はありません）

#### 2.1 XAMPPを起動してApacheWebサーバーとMySQLDatabaseサーバーを起動する．

#### 2.2 localhost/index.phpからログイン画面で以下を入力するとログインできる

    メールアドレス：testuser@example.com
    パスワード：testpass


#### 2.3 ログインできない場合：test.phpを実行(localhost/test.php)し、出てきたハッシュ値をtest.sqlのパスワードの部分に入力する

#### 2.4 ターミナルで以下のコマンド入力

    /Applications/XAMPP/xamppfiles/bin/mysql -u jazz_host -p jazzdb < /Applications/XAMPP/xamppfiles/htdocs/test.sql

    (パスワード：jazz_pass)

## 3.基本操作

#### 3.1 新規登録
名前とメールアドレスとパスワードを登録する．

#### 3.2 ログイン
メールアドレスとパスワードを登録する．

#### 3.3 曲追加
曲名，キー，種類，難易度，種類を入力して曲を登録できる．

#### 3.4 ホーム画面
今日のおすすめ曲を確認できる．
曲名，キー，種類，難易度，種類を指定して曲を検索できる．

#### 3.5 曲検索
曲名，キー，種類，難易度，種類を入力して曲を検索できる．
曲情報でソートできる．

#### 3.6 曲削除
検索した曲を削除できる．

#### 3.7 ログアウト

#### 3.8 アカウント削除


## 4.情報まとめ
### 4.1 データベース
| データベース名 | jazzdb |
| ---- | ---- |
| ユーザー名 | jazz_host |
| ホスト名 | localhost |
| パスワード | jazz_pass |

### 4.2 テーブル1 song
| テーブル名 | song |
| ---- | ---- |
| 曲ID | song_id |
| 曲名 | song-title |
| キー | song_ke |
| 拍子 | song_beat |
| 難易度 | song_standard |
| 種類 | song_type |
| 作成者 | user_id |

### 3.3 テーブル2 user
| テーブル名 | user |
| ---- | ---- |
| ID | song_id |
| 表示用ユーザー名 | username |
| メールアドレス | useremail |
| パスワード | password |