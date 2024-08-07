<?php
session_start();

$mail = $_POST['mail'];
$pass = $_POST['pass'];

$dsn = "mysql:host=localhost; dbname=jazzdb; charset=utf8";
$username = "jazz_host";
$password = "jazz_pass";

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // メールアドレスでユーザーを検索
    $sql = "SELECT * FROM user WHERE useremail = :mail";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':mail', $mail);
    $stmt->execute();
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーが見つかり、パスワードが一致するか確認
    if ($member && password_verify($pass, $member['password'])) {
        // DBのユーザー情報をセッションに保存
        $_SESSION['id'] = $member['id'];
        $_SESSION['name'] = $member['username'];
        $msg = 'ログインしました。';
        $link = '<a href="index.php">ホーム</a>';
    } else {
        // ログイン失敗
        $msg = 'メールアドレスもしくはパスワードが間違っています。';
        $link = '<a href="login_form.php">戻る</a>';
    }
} catch (PDOException $e) {
    $msg = 'データベース接続エラー: ' . $e->getMessage();
    $link = '<a href="login_form.php">戻る</a>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン結果</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <h1>My Jazz Note</h1>
    </header>

    <main>
        <section>
            <h1><?php echo $msg; ?></h1>
            <?php echo $link; ?>
        </section>
    </main>
</body>

</html>