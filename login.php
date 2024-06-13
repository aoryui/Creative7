<?php
require_once __DIR__ . '/header.php';

// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

// メッセージが空でない場合に表示
if (!empty($message)) {
    echo '<span class="message">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</span>';
}
?>

<h1>ログイン情報を入力してください</h1>
<?php
if (isset($_SESSION['login_error'])) {
    echo '<p class="message-red">' . $_SESSION['login_error'] . '</p>';
    unset($_SESSION['login_error']);
}
?>
<form action="login_db.php" method="post" class="form-groupa">
    <div class="form-group">
        <label for="username">メールアドレス：</label>
        <input type="email" id="username" name="username" required />
    </div>
    <div class="form-group">
        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password" required />
    </div>
    <button type="submit">ログイン</button>
</form>
<p><a href="signup.php">新規登録はこちら</a></p>
</body>

</html>