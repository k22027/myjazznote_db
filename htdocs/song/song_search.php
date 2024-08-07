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

// 曲の検索条件を取得
$search_title = isset($_GET['search_title']) ? $_GET['search_title'] : '';
$search_key = isset($_GET['search_key']) ? $_GET['search_key'] : '';
$search_beat = isset($_GET['search_beat']) ? $_GET['search_beat'] : '';
$search_standard = isset($_GET['search_standard']) ? $_GET['search_standard'] : '';
$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : '';

// ソート条件の取得
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'song_title'; // デフォルトのソートカラム
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC'; // デフォルトのソート順

// ソート条件の逆転
$sort_order = ($sort_order === 'ASC') ? 'DESC' : 'ASC';

// 曲の検索
$sql = "SELECT DISTINCT song_key, song_beat, song_standard, song_type FROM song";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 曲の検索（ログインしているユーザーの曲のみ）
$sql = "SELECT * FROM song WHERE user_id = :user_id";

if ($search_title) {
    $sql .= " AND song_title LIKE :search_title";
}
if ($search_key) {
    $sql .= " AND song_key = :search_key";
}
if ($search_beat) {
    $sql .= " AND song_beat = :search_beat";
}
if ($search_standard) {
    $sql .= " AND song_standard = :search_standard";
}
if ($search_type) {
    $sql .= " AND song_type = :search_type";
}

// ソート条件を追加
$sql .= " ORDER BY $sort_column $sort_order";

$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);

if ($search_title) {
    $stmt->bindValue(':search_title', '%' . $search_title . '%');
}
if ($search_key) {
    $stmt->bindValue(':search_key', $search_key);
}
if ($search_beat) {
    $stmt->bindValue(':search_beat', $search_beat);
}
if ($search_standard) {
    $stmt->bindValue(':search_standard', $search_standard);
}
if ($search_type) {
    $stmt->bindValue(':search_type', $search_type);
}

$stmt->execute();
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>曲の検索</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js" defer></script>
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
        <section>
            <h2>曲検索</h2>
            <form action="song_search.php" method="get">
                <div>
                    <label for="search_title">曲名:</label>
                    <input type="text" id="search_title" name="search_title" value="<?php echo htmlspecialchars($search_title, ENT_QUOTES); ?>">
                </div>
                <div>
                    <label for="search_key">キー:</label>
                    <select name="search_key" id="search_key">
                        <option value="">すべて</option>
                        <?php
                        $keys = array('F', 'E♭', 'C', 'B♭', 'G', 'A♭', 'D♭', 'D', 'A', 'E', 'B', 'Dm', 'Cm', 'Gm', 'Am', 'Bm', 'Em', 'B♭m', 'E♭m', 'A♭m', '未登録');
                        foreach ($keys as $key) {
                            echo "<option value=\"$key\"" . ($search_key === $key ? ' selected' : '') . ">$key</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="search_beat">拍子:</label>
                    <select name="search_beat" id="search_beat">
                        <option value="">すべて</option>
                        <?php
                        $beats = array('4/4', '3/4', '6/8', '5/4', '未登録');
                        foreach ($beats as $beat) {
                            echo "<option value=\"$beat\"" . ($search_beat === $beat ? ' selected' : '') . ">$beat</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="search_standard">難易度:</label>
                    <select name="search_standard" id="search_standard">
                        <option value="">すべて</option>
                        <?php
                        $standards = array('5', '4', '3', '2', '1');
                        foreach ($standards as $standard) {
                            echo "<option value=\"$standard\"" . ($search_standard === $standard ? ' selected' : '') . ">$standard</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="search_type">種類:</label>
                    <select name="search_type" id="search_type">
                        <option value="">すべて</option>
                        <?php
                        $types = array('Swing', 'Blues', 'Latin', 'Bossa', 'Ballade', '未登録');
                        foreach ($types as $type) {
                            echo "<option value=\"$type\"" . ($search_type === $type ? ' selected' : '') . ">$type</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" value="検索">
            </form>
        </section>

        <section>
            <h2>曲の一覧</h2>
            <?php if ($songs) : ?>
                <table>
                    <thead>
                        <tr>
                            <th class="<?php echo ($sort_column === 'song_title') ? ($sort_order === 'ASC' ? 'sorted-asc' : 'sorted-desc') : ''; ?>">
                                <a href="?search_key=<?php echo urlencode($search_key); ?>&search_beat=<?php echo urlencode($search_beat); ?>&search_standard=<?php echo urlencode($search_standard); ?>&search_type=<?php echo urlencode($search_type); ?>&sort_column=song_title&sort_order=<?php echo $sort_order; ?>">曲名</a>
                            </th>
                            <th class="<?php echo ($sort_column === 'song_key') ? ($sort_order === 'ASC' ? 'sorted-asc' : 'sorted-desc') : ''; ?>">
                                <a href="?search_key=<?php echo urlencode($search_key); ?>&search_beat=<?php echo urlencode($search_beat); ?>&search_standard=<?php echo urlencode($search_standard); ?>&search_type=<?php echo urlencode($search_type); ?>&sort_column=song_key&sort_order=<?php echo $sort_order; ?>">キー</a>
                            </th>
                            <th class="<?php echo ($sort_column === 'song_beat') ? ($sort_order === 'ASC' ? 'sorted-asc' : 'sorted-desc') : ''; ?>">
                                <a href="?search_key=<?php echo urlencode($search_key); ?>&search_beat=<?php echo urlencode($search_beat); ?>&search_standard=<?php echo urlencode($search_standard); ?>&search_type=<?php echo urlencode($search_type); ?>&sort_column=song_beat&sort_order=<?php echo $sort_order; ?>">拍子</a>
                            </th>
                            <th class="<?php echo ($sort_column === 'song_standard') ? ($sort_order === 'ASC' ? 'sorted-asc' : 'sorted-desc') : ''; ?>">
                                <a href="?search_key=<?php echo urlencode($search_key); ?>&search_beat=<?php echo urlencode($search_beat); ?>&search_standard=<?php echo urlencode($search_standard); ?>&search_type=<?php echo urlencode($search_type); ?>&sort_column=song_standard&sort_order=<?php echo $sort_order; ?>">難易度</a>
                            </th>
                            <th class="<?php echo ($sort_column === 'song_type') ? ($sort_order === 'ASC' ? 'sorted-asc' : 'sorted-desc') : ''; ?>">
                                <a href="?search_key=<?php echo urlencode($search_key); ?>&search_beat=<?php echo urlencode($search_beat); ?>&search_standard=<?php echo urlencode($search_standard); ?>&search_type=<?php echo urlencode($search_type); ?>&sort_column=song_type&sort_order=<?php echo $sort_order; ?>">種類</a>
                            </th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($songs as $song) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($song['song_title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($song['song_key'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($song['song_beat'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($song['song_standard'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($song['song_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><a href="song_edit.php?id=<?php echo $song['id']; ?>">編集</a></td>
                                <td><a href="song_delete.php?id=<?php echo $song['id']; ?>" onclick="return confirm('本当に削除しますか？');">削除</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>検索結果がありません。</p>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>