<?php
session_start();

require_once __DIR__ . '/header.php';


// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

?>
<head>
<link rel="stylesheet" href="../css/verify_code.css">
</head>
<div class="container">
    <h2>確認コード入力</h2>
    <!-- エラーメッセージを表示 -->
    <?php if (!empty($message)): ?>
        <div class="alert"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <form action="../backend/verify_code.php" method="POST" class="form-groupa">
        <div class="form-group">
            <label for="verification_code">確認コード</label>
            <input type="text" id="verification_code" name="verification_code" required />
        </div>
        <button type="submit" id="submit">確認</button>
    </form>
</div>
</body>
</html>
