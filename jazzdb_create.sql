-- MyJazzNote 初期化スクリプト
-- データベースとユーザーの作成
-- /Applications/XAMPP/xamppfiles/bin/mysql -u jazz_host -p 
-- jazz_pass

CREATE USER 'jazz_host'@'localhost' IDENTIFIED by 'jazz_pass';
CREATE DATABASE jazzdb CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON jazzdb.* TO 'jazz_host'@'localhost';
FLUSH PRIVILEGES;

-- テーブルの作成
USE jazzdb;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS song;

-- 利用者テーブルの作成
CREATE TABLE user (
    id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    useremail VARCHAR(50),
    password VARCHAR(128),
    PRIMARY KEY (id)
);

-- 曲テーブルの作成
CREATE TABLE song (
    id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
    song_title VARCHAR(100),
    song_key VARCHAR(3),
    song_beat VARCHAR(3),
    song_standard TINYINT,
    song_type VARCHAR(10),
    user_id MEDIUMINT UNSIGNED, -- 追加
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id) -- 外部キー制約
);

-- 以下はテスト用
START TRANSACTION;

-- テストユーザーの追加(新規登録でも動きます)
    -- テスト用にすでに曲の情報が登録されているアカウント
    -- 名前：test
    -- メールアドレス：testuser@example.com
    -- パスワード：testpass

INSERT INTO user (username, useremail, password) VALUES ('test', 'testuser@example.com', '$2y$10$6IkZ41Zq5ZaMjpRPIKjTf.CXRa.QhZq.JMlregB8Uyhdgae5DXc8e');

-- 最後に追加したユーザーのIDを取得
SET @user_id = LAST_INSERT_ID();

-- テストデータの挿入
INSERT INTO song (song_title, song_key, song_beat, song_standard, song_type, user_id) VALUES
('Autumn Leaves', 'Gm', '4/4', 1, 'Swing', @user_id),
('Take Five', 'E♭', '5/4', 5, 'Swing', @user_id),
('Star Eyes', 'E♭', '4/4', 3, 'Latin', @user_id),
('There will never be another you', 'E♭', '4/4', 1, 'Swing', @user_id),
('On the sunny side of street', 'C', '4/4', 1, 'Swing', @user_id);

-- トランザクションをコミット
COMMIT;