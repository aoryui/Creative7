<?php
require_once __DIR__ . '/header_login_signup.php';

// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

// メッセージが空でない場合に表示
if (!empty($message)) {
    echo '<span class="message">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</span>';
}
?>
<!DOCTYPE html>
<link rel="stylesheet" href="../css/kanrisya_login.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="login-body">
<div class="login-container">
<div class="login-ji">
<h1>管理者ログイン</h1>
</div>
<!-- ログインフォーム -->
<?php
if (isset($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
//     echo '<p class="message-red">' . $_SESSION['login_error'] . '</p>';
    unset($_SESSION['login_error']);
}
?>

<script>
        window.onload = function() {
            const loginError = "<?php echo $loginError; ?>";
            if (loginError) {
                alert(loginError);
            }
        };
    </script>

<form action="../backend/kanrisya_login_db.php" method="post" class="form-group">
    <div class="form-group">
        <label for="username">メールアドレス</label>
        <input type="text" id="username" name="username" required />
    </div>
    <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" required />
    </div>
    <button type="submit" id="login">ログイン</button>
</form>
<div class="signup button">
<p><a href="kanrisya_signup.php"><br>管理者の新規登録はこちら</a></p>
</div>
</div>

</html>
