<?php
// 必要なファイルをインクルード
require_once __DIR__ . '/../backend/pre.php'; // 事前処理スクリプト
require_once __DIR__ . '/../backend/class.php'; // クラス定義スクリプト
require_once __DIR__ . '/../frontend/header.php'; // フロントエンドのヘッダーファイル

// データベース接続情報を設定
$dsn = 'mysql:dbname=creative7;host=localhost;charset=utf8';
$user = 'Creative7';
$password = '11111';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーを例外として扱う設定

// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : ''; // GETパラメータ"message"を取得
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メールアドレス確認</title>
    <!-- CSSファイルのリンク -->
    <link rel="stylesheet" href="../css/verify.css">
    <link rel="stylesheet" href="../responsive/email_verify.css">
</head>
<body>
    <div class="container">
        <h2>メールアドレス確認</h2>
        
        <!-- エラーメッセージを表示 -->
        <?php if (!empty($message)): ?>
            <div class="alert"> <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?> </div> <!-- XSS対策でエスケープ処理 -->
        <?php endif; ?>

        <!-- メールアドレス確認フォーム -->
        <form action="../backend/send_verification_code.php" method="POST">
            <!-- メールアドレス入力欄 -->
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" required> <!-- 必須入力 -->
            
            <!-- 確認コード送信ボタン -->
            <button type="submit">確認コードを送信</button>
        </form>
    </div>
</body>
</html>
