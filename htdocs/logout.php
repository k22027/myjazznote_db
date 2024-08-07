<?php
session_start();
$_SESSION = array(); //セッションの中身をすべて削除
session_destroy(); //セッションを破壊
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <h1>My Jazz Note</h1>
    </header>

    <main>
        <section>
            <p>ログアウトしました。</p>
            <a href="login_form.php">ログインするにはこちら</a>
        </section>
    </main>
</body>

</html>