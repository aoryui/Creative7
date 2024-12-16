<?php
session_start();

require_once __DIR__ . '/header.php';

// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

// セッションからメールアドレスを取得
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'メールアドレスが設定されていません。';

// メールアドレスを加工する関数
function maskEmail($email) {
    $atPosition = strpos($email, '@'); // 「@」の位置を取得
    if ($atPosition === false) {
        return $email; // 無効なメールアドレスの場合、そのまま返す
    }

    $prefix = substr($email, 0, 2); // 先頭2文字を取得
    $domain = substr($email, $atPosition); // 「@」以降を取得
    $masked = $prefix . str_repeat('*', $atPosition - 2) . $domain; // マスク処理
    return $masked;
}

$maskedEmail = maskEmail($email); // マスク処理を適用
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>確認コード入力</title>
    <link rel="stylesheet" href="../css/verify_code.css">
</head>
<body>
<div class="container">
    <h2>確認コード入力</h2>
    <!-- メールアドレスの表示 -->
    <p><?= htmlspecialchars($maskedEmail, ENT_QUOTES, 'UTF-8') ?><br>
    に2段階認証用のセキュリティーコードを送信しました。ご確認の上、セキュリティーコードを入力してください</p>
    
    <!-- エラーメッセージを表示 -->
    <?php if (!empty($message)): ?>
        <div class="alert"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form action="../backend/verify_code_back.php" method="POST" class="form-groupa">
        <div class="form-group">
            <label for="verification_code">確認コード</label>
            <input type="text" id="verification_code" name="verification_code" required />
        </div>
        <button type="submit" id="submit">確認</button>
    </form>
</div>
</body>
</html>
