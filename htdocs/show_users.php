<?php
session_start();
$dsn = "mysql:host=localhost; dbname=jazzdb; charset=utf8";
$username = "jazz_host";
$password = "jazz_pass"; // 正しいパスワードを入力してください

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユーザーリストを取得
    $sql = "SELECT * FROM user";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Password</th><th>Actions</th></tr>";

    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($user['useremail'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($user['password'], ENT_QUOTES, 'UTF-8') . "</td>"; // ハッシュ化されたパスワード
        echo "<td><form action='delete_user.php' method='post' onsubmit='return confirmDelete()'><input type='hidden' name='id' value='" . $user['id'] . "'><input type='submit' value='削除'></form></td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
}
?>

<script>
    function confirmDelete() {
        return confirm('本当にこのユーザーを削除しますか？');
    }
</script>