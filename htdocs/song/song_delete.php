<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// データベース接続の設定
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

// 曲のIDを取得
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 曲の削除
    $sql = "DELETE FROM song WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        $msg = '曲を削除しました。';
        $link = '<a href="song_search.php">曲一覧に戻る</a>';
    } catch (PDOException $e) {
        $msg = '削除エラー: ' . $e->getMessage();
        $link = '<a href="song_search.php">戻る</a>';
    }
} else {
    $msg = '無効なアクセスです。';
    $link = '<a href="song_search.php">戻る</a>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>曲の削除</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>My Jazz Note</h1>
        <nav>
            <a href="../index.php">ホーム</a> |
            <a href="song_add.php">曲の追加</a> |
            <a href="../logout.php">ログアウト</a>
        </nav>
    </header>

    <main>
        <h1><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></h1>
        <?php echo $link; ?>
    </main>
</body>

</html>