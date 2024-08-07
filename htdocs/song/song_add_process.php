<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'];  // ログインしているユーザーのID

// データベース接続の設定
$dsn = "mysql:host=localhost; dbname=jazzdb; charset=utf8";
$db_username = "jazz_host";
$db_password = "jazz_pass";

try {
    $dbh = new PDO($dsn, $db_username, $db_password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('データベース接続エラー: ' . $e->getMessage());
}

// フォームからのデータ取得
$song_title = isset($_POST['song_title']) ? $_POST['song_title'] : '';
$song_key = isset($_POST['song_key']) ? $_POST['song_key'] : '';
$song_beat = isset($_POST['song_beat']) ? $_POST['song_beat'] : '';
$song_standard = isset($_POST['song_standard']) ? $_POST['song_standard'] : '';
$song_type = isset($_POST['song_type']) ? $_POST['song_type'] : '';

// エラーチェック
$errors = [];
if (empty($song_title)) {
    $errors[] = '曲名を入力してください。';
}
if (empty($song_key)) {
    $errors[] = 'キーを選択してください。';
}
if (empty($song_beat)) {
    $errors[] = '拍子を選択してください。';
}
if (empty($song_standard)) {
    $errors[] = '難易度を選択してください。';
}
if (empty($song_type)) {
    $errors[] = '種類を選択してください。';
}

if (!empty($errors)) {
    // エラーがある場合は前のページに戻る
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: song_add.php');
    exit;
}


// "未登録" が選択された場合に適切なデフォルト値を設定
if ($song_standard === '未登録') {
    $song_standard = null; // または他の適切なデフォルト値、例えば0
}


try {
    // データベースに曲を追加
    $sql = "INSERT INTO song (song_title, song_key, song_beat, song_standard, song_type, user_id) VALUES (:song_title, :song_key, :song_beat, :song_standard, :song_type, :user_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':song_title', $song_title);
    $stmt->bindParam(':song_key', $song_key);
    $stmt->bindParam(':song_beat', $song_beat);
    $stmt->bindParam(':song_standard', $song_standard);
    $stmt->bindParam(':song_type', $song_type);
    $stmt->bindParam(':user_id', $user_id);  // ログインしているユーザーのIDをバインド
    $stmt->execute();

    // 成功メッセージとリダイレクト
    header('Location: process_result.php?action=add');
    exit;
} catch (PDOException $e) {
    die('データベースエラー: ' . $e->getMessage());
}
