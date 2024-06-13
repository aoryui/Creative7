<?php
require_once __DIR__ . '/header.php';
?>

<h1>利用開始に必要な情報を入力してください</h1>
<?php
if (isset($_SESSION['signup_error'])) {
    echo '<p class="message-red">' . $_SESSION['signup_error'] . '</p>';
    unset($_SESSION['signup_error']);
}
?>
<form action="touroku.php" method="post" class="form-groupa">
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
</body>

</html>