<?php
// ハッシュ化するパスワード
$password = 'testpass';

// パスワードをハッシュ化
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// ハッシュ化されたパスワードを表示
echo $hashedPassword;
