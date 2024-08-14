# 「MyJazzNote」を実行するための作業と操作一覧

## 1.手元のパソコンで実行する方法

#### 1.1 zipファイルを~/htdocs/で解凍する

#### 1.2 初期化スクリプト(jazzdb_create.sql)をmysqlで使用する

    /Applications/XAMPP/xamppfiles/bin/mysql -u root -p < /Applications/XAMPP/xamppfiles/htdocs/jazzdb_create.sql  

## 2.テスト用アカウントログイン方法
（テスト用でなくてもlocalhost/index.phpから動きますが，曲を自分で追加するまで一覧やおすすめに曲はありません）

#### 2.1 XAMPPを起動してApacheWebサーバーとMySQLDatabaseサーバーを起動する．

#### 2.2 localhost/index.phpからログイン画面で以下を入力するとログインできる

    メールアドレス：testuser@example.com
    パスワード：testpass

#### 2.3 テスト用アカウントでログインできない場合：test.phpを実行(localhost/test.php)し、出てきたハッシュ値をtest.sqlのパスワードの部分に入力する

#### 2.4 ターミナルで以下のコマンド入力

    /Applications/XAMPP/xamppfiles/bin/mysql -u jazz_host -p jazzdb < /Applications/XAMPP/xamppfiles/htdocs/test.sql

    (パスワード：jazz_pass)

## 3.基本操作

#### 3.1 新規登録
名前とメールアドレスとパスワードを登録する．

<img width="250" alt="スクリーンショット 2024-08-15 1 42 13" src="https://github.com/user-attachments/assets/9a73ce6c-739c-48f4-b68a-43d7400df4ba">
<img width="250" alt="スクリーンショット 2024-08-15 1 42 54" src="https://github.com/user-attachments/assets/154d6b64-7ff5-4957-ad11-89b70bbe8b5e">
<img width="250" alt="スクリーンショット 2024-08-15 1 43 35" src="https://github.com/user-attachments/assets/df3dadc7-f7ef-40de-a708-1946944890cb">

#### 3.2 ログイン
メールアドレスとパスワードを登録する．

<img width="250" alt="スクリーンショット 2024-08-15 1 43 50" src="https://github.com/user-attachments/assets/4d886b8c-09c6-42a9-946c-f336ead7a79c">
<img width="250" alt="スクリーンショット 2024-08-15 1 43 55" src="https://github.com/user-attachments/assets/9d703a4d-9eb3-4268-a1f8-b1fa64a484dd">


#### 3.3 ホーム画面
今日のおすすめ曲を確認できる．
曲名，キー，種類，難易度，種類を指定して曲を検索できる．

<img width="250" alt="スクリーンショット 2024-08-15 1 43 58" src="https://github.com/user-attachments/assets/4d5d5740-7fa3-41ad-bb4d-d0e5cec970a6">
<img width="250" alt="スクリーンショット 2024-08-15 2 15 26" src="https://github.com/user-attachments/assets/fe3c6269-1c5e-483c-a0e8-316b8d40b118">
<img width="250" alt="スクリーンショット 2024-08-15 1 44 03" src="https://github.com/user-attachments/assets/d43b3267-7f72-4930-9cce-e0054a75ca6a">

#### 3.4 曲追加
曲名，キー，種類，難易度，種類を入力して曲を登録できる．

<img width="250" alt="スクリーンショット 2024-08-15 1 45 10" src="https://github.com/user-attachments/assets/b75ae24d-c83c-4001-98e2-14b59e43383d">
<img width="250" alt="スクリーンショット 2024-08-15 1 45 44" src="https://github.com/user-attachments/assets/f78e3183-5607-46a6-a7ef-15435f800038">
<img width="250" alt="スクリーンショット 2024-08-15 1 45 55" src="https://github.com/user-attachments/assets/57a516d9-cc56-4613-9ea2-c5fc07a7f082">


#### 3.5 曲検索
曲名，キー，種類，難易度，種類を入力して曲を検索できる．
曲情報でソートできる．

<img width="250" alt="スクリーンショット 2024-08-15 1 46 29" src="https://github.com/user-attachments/assets/bd378c72-5aef-400d-91f6-da29f3181169">
<img width="250" alt="スクリーンショット 2024-08-15 1 46 21" src="https://github.com/user-attachments/assets/0b6180fc-e591-4c1a-8d78-a677c4b597f6">
<img width="250" alt="スクリーンショット 2024-08-15 2 16 03" src="https://github.com/user-attachments/assets/273700a3-e68f-4311-a251-55d62eded4d8">
<img width="250" alt="スクリーンショット 2024-08-15 2 16 23" src="https://github.com/user-attachments/assets/6c5e7b78-3578-4f88-8c57-9f31e7d221c8">
<img width="250" alt="スクリーンショット 2024-08-15 2 16 16" src="https://github.com/user-attachments/assets/25bde1c3-9eb9-44dc-82c1-3954c816f5c2">


#### 3.6 曲編集
検索した曲を編集できる．

<img width="250" alt="スクリーンショット 2024-08-15 1 59 49" src="https://github.com/user-attachments/assets/16f6afbf-a888-49c6-9149-265dac4c1738">
<img width="250" alt="スクリーンショット 2024-08-15 1 59 57" src="https://github.com/user-attachments/assets/7908f735-631b-4c43-918d-dd70d2ea9a66">
<img width="250" alt="スクリーンショット 2024-08-15 2 00 01" src="https://github.com/user-attachments/assets/c65ca6d2-aa1e-4dbd-bb68-7da587682ac2">

#### 3.7 曲削除
検索した曲を削除できる．

<img width="250" alt="スクリーンショット 2024-08-15 2 00 05" src="https://github.com/user-attachments/assets/e893ee1a-ff75-4afb-b19d-37884e4d4314">
<img width="250" alt="スクリーンショット 2024-08-15 2 00 08" src="https://github.com/user-attachments/assets/cde66c51-7cd3-40a2-a022-6bc52a014668">

#### 3.8 ログアウト
ログアウトできる．曲情報は削除されない．

<img width="250" alt="スクリーンショット 2024-08-15 1 46 45" src="https://github.com/user-attachments/assets/c593bd73-185f-4917-88cf-c9d9b9a50991">
<img width="250" alt="スクリーンショット 2024-08-15 1 46 50" src="https://github.com/user-attachments/assets/02c8ed10-eba4-4060-82b6-64840bfbc550">

#### 3.9 アカウント削除
アカウント情報を削除できる．曲情報も削除される．

<img width="250" alt="スクリーンショット 2024-08-15 1 47 07" src="https://github.com/user-attachments/assets/b272565d-a9f2-41a3-b693-36ac077df1d0">
<img width="250" alt="スクリーンショット 2024-08-15 1 47 10" src="https://github.com/user-attachments/assets/19fec05c-3149-4f21-bcea-9c5acd7d7dc4">
<img width="250" alt="スクリーンショット 2024-08-15 1 47 17" src="https://github.com/user-attachments/assets/45e0f6b9-a8fd-4d1a-9847-515781b9b56c">

## 4.情報まとめ
### 4.1 データベース
| データベース名 | jazzdb |
| ---- | ---- |
| ユーザー名 | jazz_host |
| ホスト名 | localhost |
| パスワード | jazz_pass |

### 4.2 songテーブル
| テーブル名 | song |
| ---- | ---- |
| 曲ID | song_id |
| 曲名 | song-title |
| キー | song_key |
| 拍子 | song_beat |
| 難易度 | song_standard |
| 種類 | song_type |
| 作成者 | user_id |

### 4.3 userテーブル
| テーブル名 | user |
| ---- | ---- |
| ID | song_id |
| 表示用ユーザー名 | username |
| メールアドレス | useremail |
| パスワード | password |

### 4.4 実装環境
- MacOS: sonoma 14.3
- Apache: 2.4.56
- XAMPP for OS X:7.4.33-0
- MariaDB: 10.4.27
- Perl: 5.30.3
- MySQL Native Driver: 7.4.33 
- PHP: 7.4.33