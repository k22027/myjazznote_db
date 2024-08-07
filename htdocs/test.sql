-- トランザクションを開始
START TRANSACTION;

-- テストユーザーの追加
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
