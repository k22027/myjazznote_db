<?php
session_start();

// データベース接続の設定
$dsn = "mysql:host=localhost; dbname=jazzdb; charset=utf8";
$db_username = "jazz_host";
$db_password = "jazz_pass";

try {
    $dbh = new PDO($dsn, $db_username, $db_password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'データベース接続エラー: ' . $e->getMessage();
    exit;
}

// ユーザーがログインしていることを確認
if (!isset($_SESSION['id'])) {
    echo '<p>ログインしていません。ログインしてください。</p>';
    echo '<a href="login.php">ログインページへ</a>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $user_id = $_SESSION['id'];

        try {
            // 曲情報の削除
            $sql = "DELETE FROM song WHERE user_id = :user_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // ユーザー情報の削除
            $sql = "DELETE FROM user WHERE id = :user_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // セッション情報のクリアとログアウト
            $_SESSION = array();
            session_destroy();

            $message = "アカウントが削除されました。";
            $link = '<a href="index.php">新規登録はこちら</a>';
        } catch (PDOException $e) {
            $message = 'エラー: ' . $e->getMessage();
            $link = '<a href="index.php">ホームに戻る</a>';
        }
    } elseif (isset($_POST['confirm']) && $_POST['confirm'] === 'no') {
        $message = "アカウント削除がキャンセルされました。";
        $link = '<a href="index.php">ホームに戻る</a>';
    }
} else {
    // 削除確認フォームの表示
?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>アカウント削除確認</title>
        <link rel="stylesheet" href="../css/style.css"> <!-- CSSのパス -->
    </head>

    <body>
        <header>
            <h1>My Jazz Note</h1>
            <nav>
                <a href="../index.php">ホーム</a> |
                <a href="../logout.php">ログアウト</a>
            </nav>
        </header>

        <main>
            <section class="delete-user">
                <h2>アカウント削除の確認</h2>
                <form method="post" action="">
                    <p>本当にアカウントを削除してもよろしいですか？この操作は取り消せません。</p>
                    <input type="submit" name="confirm" value="yes"> はい
                    <input type="submit" name="confirm" value="no"> いいえ
                </form>
            </section>
        </main>
    </body>

    </html>
<?php
}
?>

<?php if (isset($message)) : ?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>結果</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <header>
            <h1>My Jazz Note</h1>
            <nav>
                <a href="../index.php">ホーム</a> |
                <a href="../logout.php">ログアウト</a>
            </nav>
        </header>

        <main>
            <section class="result">
                <h2><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p><?php echo $link; ?></p>
            </section>
        </main>
    </body>

    </html>
<?php endif; ?>