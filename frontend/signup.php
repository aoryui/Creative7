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
<form action="../backend/touroku.php" method="post" class="form-group">
    <div class="form-group">
        <label for="username" id="usernames">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="school" id="schools">所属学科:</label>
        <select id="school" name="school" required>
            <option value="">学科を選択</option>
            <option value="ITエキスパート学科">ITエキスパート学科</option>
            <option value="ITスペシャリスト学科">ITスペシャリスト学科</option>
            <option value="情報処理学科">情報処理学科</option>
            <option value="AIシステム開発学科">AIシステム開発学科</option>
        </select>
    </div>
    <div class="form-group">
        <label for="address" id="addresses">メールアドレス:</label>
        <input type="email" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="password" id="passwords">パスワード:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" id="submit">登録</button>
</form>
</div>
</div>
</body>

</html>
