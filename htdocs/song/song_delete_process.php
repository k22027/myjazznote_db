<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id']);

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

// 曲の削除
$sql = "DELETE FROM song WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $stmt->execute();
    header('Location: process_result.php?action=delete');
    exit;
} catch (PDOException $e) {
    $msg = 'クエリエラー: ' . $e->getMessage();
    echo '<h1>' . $msg . '</h1>';
    exit;
}
