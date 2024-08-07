<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo '<h1>曲IDが指定されていません</h1>';
    exit;
}

$id = intval($_GET['id']);

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

// 曲情報の取得（ログインしているユーザーの曲のみ）
$sql = "SELECT * FROM song WHERE id = :id AND user_id = :user_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
try {
    $stmt->execute();
    $song = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $msg = 'クエリエラー: ' . $e->getMessage();
    echo '<h1>' . $msg . '</h1>';
    exit;
}

if (!$song) {
    echo '<h1>曲が見つかりません</h1>';
    exit;
}


// エラーメッセージを初期化
$errors = [];

// セッションからエラーメッセージを取得
if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

// セッションからフォームデータを取得
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>曲の編集</title>
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
        <form action="song_edit_process.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
            <div>
                <label for="song_title">曲名:</label>
                <input type="text" name="song_title" id="song_title" value="<?php echo htmlspecialchars($form_data['song_title'] ?? $song['song_title'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div>
                <label for="song_key">キー:</label>
                <select name="song_key" id="song_key">
                    <option value="">選択してください</option>
                    <?php
                    $keys = array('F', 'E♭', 'C', 'B♭', 'G', 'A♭', 'D♭', 'D', 'A', 'E', 'B', 'Dm', 'Cm', 'Gm', 'Am', 'Bm', 'Em', 'B♭m', 'E♭m', 'A♭m', '未登録');
                    foreach ($keys as $key) {
                        echo "<option value=\"$key\"" . ((isset($form_data['song_key']) && $form_data['song_key'] === $key) || ($song['song_key'] === $key && !isset($form_data['song_key'])) ? ' selected' : '') . ">$key</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="song_beat">拍子:</label>
                <select name="song_beat" id="song_beat">
                    <option value="">選択してください</option>
                    <?php
                    $beats = array('4/4', '3/4', '6/8', '5/4', '未登録');
                    foreach ($beats as $beat) {
                        echo "<option value=\"$beat\"" . ((isset($form_data['song_beat']) && $form_data['song_beat'] === $beat) || ($song['song_beat'] === $beat && !isset($form_data['song_beat'])) ? ' selected' : '') . ">$beat</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="song_standard">難易度:</label>
                <select name="song_standard" id="song_standard">
                    <option value="">選択してください</option>
                    <?php
                    $standards = array('5', '4', '3', '2', '1');
                    foreach ($standards as $standard) {
                        echo "<option value=\"$standard\"" . ((isset($form_data['song_standard']) && $form_data['song_standard'] === $standard) || ($song['song_standard'] === $standard && !isset($form_data['song_standard'])) ? ' selected' : '') . ">$standard</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="song_type">種類:</label>
                <select name="song_type" id="song_type">
                    <option value="">選択してください</option>
                    <?php
                    $types = array('Swing', 'Blues', 'Latin', 'Bossa', 'Ballade', '未登録');
                    foreach ($types as $type) {
                        echo "<option value=\"$type\"" . ((isset($form_data['song_type']) && $form_data['song_type'] === $type) || ($song['song_type'] === $type && !isset($form_data['song_type'])) ? ' selected' : '') . ">$type</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <input type="submit" value="完了">
            </div>
        </form>

        <?php if ($errors) : ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>