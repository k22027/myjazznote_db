<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインページ</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <h1>My Jazz Note</h1>
    </header>

    <main>
        <section>
            <h1>ログインページ</h1>
            <form action="login.php" method="post">
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
                <input type="submit" value="ログイン">
            </form>
            <p><a href="index.php">新規登録をするにはこちら</a></p>
        </section>
    </main>
</body>

</html>