<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
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
    <title>曲の追加</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>My Jazz Note</h1>
        <nav>
            <a href="../index.php">ホーム</a> |
            <a href="song_search.php">曲の編集</a> |
            <a href="../logout.php">ログアウト</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>曲の追加</h2>
            <form action="song_add_process.php" method="post">
                <div>
                    <label for="song_title">曲名:</label>
                    <input type="text" name="song_title" id="song_title" value="<?php echo htmlspecialchars($form_data['song_title'] ?? '', ENT_QUOTES); ?>" required>
                </div>
                <div>
                    <label for="song_key">キー:</label>
                    <select name="song_key" id="song_key">
                        <option value="">選択してください</option>
                        <?php
                        $keys = array('F', 'E♭', 'C', 'B♭', 'G', 'A♭', 'D♭', 'D', 'A', 'E', 'B', 'Dm', 'Cm', 'Gm', 'Am', 'Bm', 'Em', 'B♭m', 'E♭m', 'A♭m', '未登録');
                        foreach ($keys as $key) {
                            echo "<option value=\"$key\"" . (isset($form_data['song_key']) && $form_data['song_key'] === $key ? ' selected' : '') . ">$key</option>";
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
                            echo "<option value=\"$beat\"" . (isset($form_data['song_beat']) && $form_data['song_beat'] === $beat ? ' selected' : '') . ">$beat</option>";
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
                            echo "<option value=\"$standard\"" . (isset($form_data['song_standard']) && $form_data['song_standard'] === $standard ? ' selected' : '') . ">$standard</option>";
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
                            echo "<option value=\"$type\"" . (isset($form_data['song_type']) && $form_data['song_type'] === $type ? ' selected' : '') . ">$type</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <input type="submit" value="追加">
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
        </section>
    </main>
</body>

</html>