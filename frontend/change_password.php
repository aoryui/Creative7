<?php
// 必要なファイルをインクルード
require_once __DIR__ . '/../backend/pre.php'; // 事前処理用スクリプト
require_once __DIR__ . '/../backend/class.php'; // クラス定義スクリプト
require_once __DIR__ . '/header.php'; // ヘッダーファイル

// データベース接続情報を設定
$dsn = 'mysql:dbname=creative7;host=localhost;charset=utf8';
$user = 'Creative7';
$password = '11111';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーを例外として扱う設定

// セッションにユーザーIDが存在する場合は取得
if (isset($_SESSION['userId'])) {
    $userid = $_SESSION['userId'];
}
?>

<?php
// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

// メッセージが空でない場合に表示
if (!empty($message)) {
    echo '<span class="message-red">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</span>'; // XSS対策としてエスケープ処理
}
?>

<head>
<link rel="stylesheet" href="../css/passchange.css"> <!-- スタイルシートのリンク -->
</head>
<div class="container">
<h2>パスワード変更</h2>
<form action="../backend/changepass.php" method="POST" class="form-groupa" id="passwordForm">
    <!-- 現在のパスワード入力欄 -->
    <div class="form-group">
        <label for="old_password">現在のパスワード</label>
        <input type="password" id="old_password" name="old_password" required />
    </div>
    <!-- 新しいパスワード入力欄 -->
    <div class="form-group">
        <label for="new_password">新しいパスワード</label>
        <input type="password" id="new_password" name="new_password" required />
    </div>
    <!-- 新しいパスワード確認入力欄 -->
    <div class="form-group">
        <label for="confirm_password">新しいパスワード（確認用）</label>
        <input type="password" id="confirm_password" name="confirm_password" required />
        <!-- パスワード不一致エラーメッセージ -->
        <span id="error-message" style="color: red; display: none;">同じ値を入力してください</span>
    </div>
    <button type="submit" id="submit">パスワード変更</button>
</form>
</div>
<script>
    // DOM要素の取得
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const errorMessage = document.getElementById('error-message');

    // 確認パスワード入力時に値を比較し、背景色とエラーメッセージを制御
    confirmPassword.addEventListener('input', () => {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.style.backgroundColor = 'pink'; // 不一致の場合はピンク色の背景
            errorMessage.style.display = 'block'; // エラーメッセージを表示
        } else {
            confirmPassword.style.backgroundColor = ''; // 背景色をリセット
            errorMessage.style.display = 'none'; // エラーメッセージを非表示
        }
    });

    // フォーム送信時に確認パスワードの一致をチェック
    document.getElementById('passwordForm').addEventListener('submit', (e) => {
        if (newPassword.value !== confirmPassword.value) {
            e.preventDefault(); // フォーム送信をキャンセル
            confirmPassword.style.backgroundColor = 'pink'; // 不一致の場合の背景色
            errorMessage.style.display = 'block'; // エラーメッセージを表示
        }
    });
</script>
</body>
</html>
