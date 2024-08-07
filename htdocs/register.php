<?php
// フォームからの値をそれぞれ変数に代入
$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

$dsn = "mysql:host=localhost; dbname=jazzdb; charset=utf8";
$username = "jazz_host";
$password = "jazz_pass";

try {
    // データベース接続の作成
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
} catch (PDOException $e) {
    // データベース接続エラーの処理
    $msg = 'データベース接続エラー: ' . $e->getMessage();
    echo '<h1>' . $msg . '</h1>';
    exit;
}

// フォームに入力されたmailがすでに登録されていないかチェック
$sql = "SELECT * FROM user WHERE useremail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
try {
    $stmt->execute();
    $member = $stmt->fetch();
} catch (PDOException $e) {
    // クエリエラーの処理
    $msg = 'クエリエラー: ' . $e->getMessage();
    echo '<h1>' . $msg . '</h1>';
    exit;
}

if ($member) {
    $msg = '同じメールアドレスが存在します。';
    $link = '<a href="index.php">戻る</a>';
} else {
    // 登録されていなければinsert 
    $sql = "INSERT INTO user(username, useremail, password) VALUES (:name, :mail, :pass)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':pass', $pass);
    try {
        $stmt->execute();
        $msg = '会員登録が完了しました';
        $link = '<a href="login_form.php">ログインページ</a>';
    } catch (PDOException $e) {
        // クエリエラーの処理
        $msg = 'クエリエラー: ' . $e->getMessage();
        $link = '<a href="index.php">戻る</a>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録結果</title>
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