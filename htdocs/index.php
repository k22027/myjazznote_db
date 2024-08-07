<?php
session_start();

// データベース接続の設定
$dsn = "mysql:host=localhost; dbname=jazzdb; charset=utf8";
$username = "jazz_host";
$password = "jazz_pass";

$recommendation = null;
$loggedIn = isset($_SESSION['name']);

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $msg = 'データベース接続エラー: ' . $e->getMessage();
    echo '<h1>' . $msg . '</h1>';
    exit;
}

// 今日のおすすめとしてランダムに1曲を選択（ログインしているユーザーの曲のみ）
if ($loggedIn) {
    $userId = $_SESSION['id'];
    $sql = "SELECT * FROM song WHERE user_id = :user_id ORDER BY RAND() LIMIT 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $recommendation = $stmt->fetch(PDO::FETCH_ASSOC);
}


$loggedIn = isset($_SESSION['name']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム</title>
    <link rel="stylesheet" href="/css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loggedIn = <?php echo json_encode($loggedIn); ?>;
            const protectedLinks = document.querySelectorAll('.protected');
            const logoutLink = document.querySelector('#logout-link');

            if (!loggedIn) {
                protectedLinks.forEach(link => {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();
                        alert('ログインしてください。');
                    });
                });
            }

            if (logoutLink) {
                logoutLink.addEventListener('click', function(event) {
                    if (!confirm('本当にログアウトしますか？')) {
                        event.preventDefault();
                    }
                });
            }
        });
    </script>
</head>

<body>
    <header>
        <h1>My Jazz Note</h1>
        <nav>
            <a href="../index.php">ホーム</a> |
            <a href="/song/song_add.php" class="protected">曲の追加</a> |
            <a href="../logout.php" id="logout-link">ログアウト</a> |
            <a href="../delete_user.php" class="protected">アカウント削除</a>
        </nav>
    </header>

    <main>
        <?php if ($loggedIn) : ?>
            <section class="recommendation">
                <h2><?php echo htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); ?>さんの今日のおすすめ曲</h2>
                <?php if ($recommendation) : ?>
                    <p><strong>曲名:</strong> <?php echo htmlspecialchars($recommendation['song_title'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>キー:</strong> <?php echo htmlspecialchars($recommendation['song_key'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>拍子:</strong> <?php echo htmlspecialchars($recommendation['song_beat'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>難易度:</strong> <?php echo htmlspecialchars($recommendation['song_standard'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>種類:</strong> <?php echo htmlspecialchars($recommendation['song_type'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php else : ?>
                    <p>おすすめの曲が見つかりませんでした。</p>
                <?php endif; ?>
            </section>

            <section class="search-form">
                <h2>曲の検索</h2>
                <form action="/song/song_search.php" method="get">
                    <label for="song_title">曲名:</label>
                    <input type="text" id="song_title" name="search_key">
                    <br>
                    <label for="song_key">キー:</label>
                    <select name="search_key" id="song_key">
                        <option value="">選択してください</option>
                        <?php
                        $keys = array('F', 'E♭', 'C', 'B♭', 'G', 'A♭', 'D♭', 'D', 'A', 'E', 'B', 'Dm', 'Cm', 'Gm', 'Am', 'Bm', 'Em', 'B♭m', 'E♭m', 'A♭m', '未登録');
                        foreach ($keys as $key) {
                            echo "<option value=\"$key\">" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <label for="song_beat">拍子:</label>
                    <select name="search_beat" id="song_beat">
                        <option value="">選択してください</option>
                        <?php
                        $beats = array('4/4', '3/4', '6/8', '5/4', '未登録');
                        foreach ($beats as $beat) {
                            echo "<option value=\"$beat\">" . htmlspecialchars($beat, ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <label for="song_standard">難易度:</label>
                    <select name="search_standard" id="song_standard">
                        <option value="">選択してください</option>
                        <?php
                        $standards = array('5', '4', '3', '2', '1');
                        foreach ($standards as $standard) {
                            echo "<option value=\"$standard\">" . htmlspecialchars($standard, ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <label for="song_type">種類:</label>
                    <select name="search_type" id="song_type">
                        <option value="">選択してください</option>
                        <?php
                        $types = array('Swing', 'Blues', 'Latin', 'Bossa', 'Ballade', '未登録');
                        foreach ($types as $type) {
                            echo "<option value=\"$type\">" . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" value="検索">
                </form>
            </section>

        <?php else : ?>
            <section id="signup">
                <h1>新規会員登録</h1>
                <form action="register.php" method="post">
                    <div>
                        <label>
                            名前：
                            <input type="text" name="name" required>
                        </label>
                    </div>
                    <div>
                        <label>
                            メールアドレス：
                            <input type="text" name="mail" required>
                        </label>
                    </div>
                    <div>
                        <label>
                            パスワード：
                            <input type="password" name="pass" required>
                        </label>
                    </div>
                    <input type="submit" value="新規登録">
                </form>
                <p><a href="login_form.php">すでに登録済みの方はこちら</a></p>
            </section>
        <?php endif; ?>
    </main>

    <section class="summary-container">
        <summary>このサイトはJazzに関わる全ての人のための曲管理サイトです。

        </summary>
    </section>
</body>

</html>