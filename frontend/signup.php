<?php
require_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<link rel="stylesheet" href="../css/signup.css">
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
<form action="touroku.php" method="post" class="form-group">
    <div class="form-group">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="school">所属学科:</label>
        <input type="school" id="school" name="school" required>
    </div>
    <div class="form-group">
        <label for="address">メールアドレス:</label>
        <input type="address" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">登録</button>
</form>
</div>
</div>
</body>

</html>
