<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        $msg = '曲の追加が完了しました。';
        $link = '<a href="song_add.php">さらに新しい曲を追加する</a>  <a href="song_search.php">曲の一覧に戻る</a>';
        break;
    case 'edit':
        $msg = '曲の編集が完了しました。';
        $link = '<a href="song_search.php">曲の一覧に戻る</a>';
        break;
    case 'delete':
        $msg = '曲の削除が完了しました。';
        $link = '<a href="song_search.php">曲の一覧に戻る</a>';
        break;
    default:
        $msg = '不正なリクエストです。';
        $link = '<a href="../index.php">ホームに戻る</a>';
        break;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>処理結果</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>処理結果</h1>
        <a href="../index.php">ホーム</a> |
        <a href="song_search.php">曲の検索</a> |
        <a href="../logout.php">ログアウト</a>
    </header>

    <main>
        <h1><?php echo $msg; ?></h1>
        <?php echo $link; ?>
    </main>
</body>

</html>