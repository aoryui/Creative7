<?php
require_once __DIR__ . '/pre.php';
require_once __DIR__ . '/database/class.php';

// 接続
$dsn = 'mysql:dbname=ilove;host=localhost;charset=utf8';
$user = 'Ilove';
$password = '11111';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if (isset($_SESSION['userId'])) {
    $userid = $_SESSION['userId'];
}

require_once __DIR__ . '/header.php'
?>

<h1>現在のパスワードと新しいパスワードを入力してください</h1>
<?php
// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

// メッセージが空でない場合に表示
if (!empty($message)) {
    echo '<span class="message-red">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</span>';
}
?>

<form action="changepass.php" method="POST" class="form-groupa">
    <div class="form-group">
        <label for="old_password">現在のパスワード：</label>
        <input type="password" id="old_password" name="old_password" required />
    </div>
    <div class="form-group">
        <label for="new_password">新しいパスワード：</label>
        <input type="password" id="new_password" name="new_password" required />
    </div>
    <button type="submit">変更</button>
</form>
</body>

</html>