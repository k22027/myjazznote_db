<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: song_search.php');
    exit;
}

$song_id = intval($_POST['id']);
$song_title = $_POST['song_title'];
$song_key = $_POST['song_key'];
$song_beat = $_POST['song_beat'];
$song_standard = $_POST['song_standard'];
$song_type = $_POST['song_type'];

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
    header('Location: song_edit.php?id=' . $song_id);
    exit;
}

$dsn = "mysql:host=localhost; dbname=jazzdb; charset=utf8";
$db_username = "jazz_host";
$db_password = "jazz_pass";

try {
    $dbh = new PDO($dsn, $db_username, $db_password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $msg = 'データベース接続エラー: ' . $e->getMessage();
    echo '<h1>' . $msg . '</h1>';
    exit;
}

// 曲の更新
$sql = "UPDATE song SET song_title = :title, song_key = :key, song_beat = :beat, song_standard = :standard, song_type = :type WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':title', $song_title);
$stmt->bindValue(':key', $song_key);
$stmt->bindValue(':beat', $song_beat);
$stmt->bindValue(':standard', $song_standard);
$stmt->bindValue(':type', $song_type);
$stmt->bindValue(':id', $song_id);

try {
    $stmt->execute();
    header('Location: process_result.php?action=edit');
    exit;
} catch (PDOException $e) {
    $msg = 'クエリエラー: ' . $e->getMessage();
    echo '<h1>' . $msg . '</h1>';
    exit;
}
