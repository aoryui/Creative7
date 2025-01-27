<?php
// ヘッダーの読み込み。ログイン・サインアップ用のヘッダーが含まれていると思われる。
require_once __DIR__ . '/header_login_signup.php';
?>

<!DOCTYPE html>
<!-- CSSファイルの読み込み（サインアップ画面用） -->
<link rel="stylesheet" href="../css/kanrisya_signup.css">
<!-- ビューポートの設定（モバイル対応） -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- ログインフォームのコンテナ -->
<div class="login-body">
    <div class="login-container">
        <!-- 新規登録の見出し -->
        <div class="login-ji">
            <h1>新規登録</h1>
        </div>

        <?php
        // セッションにsignup_errorがあればエラーメッセージを表示
        if (isset($_SESSION['signup_error'])) {
            echo '<p class="message-red">' . $_SESSION['signup_error'] . '</p>';
            unset($_SESSION['signup_error']); // エラーメッセージを表示後、セッションから削除
        }
        ?>

        <!-- サインアップフォーム -->
        <form action="../backend/kanrisya_touroku.php" method="post" class="form-group">
            <!-- ユーザー名入力フィールド -->
            <div class="form-group">
                <label for="username" id="usernames">ユーザー名:</label>
                <input type="text" id="username" name="username" required> <!-- 必須項目 -->
            </div>

            <!-- メールアドレスとパスワード入力フィールド -->
            <div class="form-group">
                <label for="address" id="addresses">メールアドレス:</label>
                <input type="email" id="address" name="address" required> <!-- メールアドレス必須 -->
                
                <label for="password" id="passwords">パスワード:</label>
                <input type="password" id="password" name="password" required> <!-- パスワード必須 -->
            </div>

            <!-- サインアップボタン -->
            <button type="submit" id="submit">登録</button>
        </form>

    </div>
</div>

</body>
</html>
