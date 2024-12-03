<?php
require_once __DIR__ . '/../backend/pre.php';
require_once __DIR__ . '/../backend/class.php';
require_once __DIR__ . '/header.php';

// 接続
$dsn = 'mysql:dbname=creative7;host=localhost;charset=utf8';
$user = 'Creative7';
$password = '11111';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if (isset($_SESSION['userId'])) {
    $userid = $_SESSION['userId'];
}

?>

<?php
// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

// メッセージが空でない場合に表示
if (!empty($message)) {
    echo '<span class="message-red">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</span>';
}
?>
<head>
<link rel="stylesheet" href="../css/passchange.css">
</head>
<div class="container">
<h2>パスワード変更</h2>
<form action="../backend/changepass.php" method="POST" class="form-groupa">
    <div class="form-group">
        <label for="old_password">現在のパスワード</label>
        <input type="password" id="old_password" name="old_password" required />
    </div>
    <div class="form-group">
        <label for="new_password">新しいパスワード</label>
        <input type="password" id="new_password" name="new_password" required />
    </div>
    <button type="submit" id="submit">パスワード変更</button>
</form>
</div>
</body>

</html>
