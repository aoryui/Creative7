<?php
require_once __DIR__ . '/header_login_signup.php';
?>
<!DOCTYPE html>
<link rel="stylesheet" href="../css/kanrisya_signup.css">
<div class="login-body">
<div class="login-container">
<div class="login-ji">
<h1>新規登録</h1>
</div>
<?php
if (isset($_SESSION['signup_error'])) {
    echo '<p class="message-red">' . $_SESSION['signup_error'] . '</p>';
    unset($_SESSION['signup_error']);
}
?>
<form action="../backend/kanrisya_touroku.php" method="post" class="form-group">
    <div class="form-group">
        <label for="username" id="usernames">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="address" id="addresses">メールアドレス:</label>
        <input type="email" id="address" name="address" required>

        <label for="password" id="passwords">パスワード:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" id="submit">登録</button>
</form>
<div class="signup button">
<p><a href="kanrisya_login.php"><br>管理者ログインに戻る</a></p>
</div>

</div>
</body>

</html>
