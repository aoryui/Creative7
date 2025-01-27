<?php
// ヘッダーを読み込む
require_once __DIR__ . '/header.php';

// URLパラメータからメッセージを取得（GETメソッドで送信されたメッセージ）
$message = isset($_GET['message']) ? $_GET['message'] : ''; // 'message' パラメータがあればその値を、なければ空文字を格納

// メッセージが空でない場合に表示
if (!empty($message)) {
    // 取得したメッセージを表示（HTMLエスケープして安全に表示）
    echo '<span class="message">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</span>';
}
?>
<!DOCTYPE html>
<link rel="stylesheet" href="../css/login.css"> <!-- ログインページのスタイルシート -->
<link rel="stylesheet" href="../responsive/login.css"> <!-- レスポンシブ対応のスタイルシート -->
<div class="login-body">
<div class="login-container">
<div class="login-ji">
<h1>ログイン</h1> <!-- ログインページのタイトル -->
</div>

<!-- ログインフォーム -->
<?php
// セッションにエラーが保存されている場合に表示
if (isset($_SESSION['login_error'])) {
    // ログインエラーメッセージをセッションから取得
    $loginError = $_SESSION['login_error'];
    // セッションからエラーメッセージを削除（1回限り表示させるため）
    unset($_SESSION['login_error']);
}
?>

<script>
// ページ読み込み後にエラーメッセージをアラートで表示
window.onload = function() {
    const loginError = "<?php echo $loginError; ?>"; // PHPからエラーメッセージをJSに渡す
    if (loginError) {
        // エラーメッセージがあればアラートで表示
        alert(loginError);
    }
};
</script>

<!-- ログインフォーム -->
<form action="../backend/login_db.php" method="post" class="form-group">
    <!-- メールアドレス入力フィールド -->
    <div class="form-group">
        <label for="username">メールアドレス</label> <!-- 入力フィールドのラベル -->
        <input type="text" id="username" name="username" required /> <!-- メールアドレス入力フィールド -->
    </div>
    
    <!-- パスワード入力フィールド -->
    <div class="form-group">
        <label for="password">パスワード</label> <!-- 入力フィールドのラベル -->
        <input type="password" id="password" name="password" required /> <!-- パスワード入力フィールド -->
    </div>
    
    <!-- ログインボタン -->
    <button type="submit" id="login">ログイン</button>
</form>

<!-- 新規登録ページへのリンク -->
<div class="signup button">
    <p><a href="signup.php"><br>新規登録はこちら</a></p>
</div>

</html>
