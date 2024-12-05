<?php
require_once __DIR__ . '/../backend/pre.php';
require_once __DIR__ . '/../backend/class.php';
require_once __DIR__ . '/../frontend/header.php';


$dsn = 'mysql:dbname=creative7;host=localhost;charset=utf8';
$user = 'Creative7';
$password = '11111';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メールアドレス確認</title>
    <link rel="stylesheet" href="../css/verify.css">
    <link rel="stylesheet" href="../responsive/email_verify.css">
</head>
<body>
    <div class="container">
        <h2>メールアドレス確認</h2>
        
        <!-- エラーメッセージを表示 -->
        <?php if (!empty($message)): ?>
            <div class="alert"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form action="../backend/send_verification_code.php" method="POST">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">確認コードを送信</button>
        </form>
    </div>
</body>
</html>
